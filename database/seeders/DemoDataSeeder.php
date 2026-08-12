<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * DemoDataSeeder
 *
 * Seeds the database with safe, realistic-looking demo data so teammates
 * can develop and test UI changes without needing a production DB dump.
 *
 * Usage:
 *   php artisan db:seed --class=DemoDataSeeder
 *
 * Or via the SEED_DEMO_DATA env variable (called from DatabaseSeeder):
 *   SEED_DEMO_DATA=true php artisan db:seed
 *
 * Safe to re-run: checks for existing demo records before inserting.
 */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Seeding demo data for VirratPOS...');

        $userId   = $this->seedDemoUser();
        $storeId  = $this->seedDemoStore($userId);
        $catIds   = $this->seedProductCategories($storeId);
        $taxId    = $this->seedProductTax($storeId);
        $productIds = $this->seedProducts($storeId, $catIds, $taxId);
        $this->seedOrders($storeId, $productIds);

        $this->command->info('✅ Demo data seeded successfully.');
        $this->command->line('   Login: demo@virratpos.test / password');
    }

    // -------------------------------------------------------------------------
    // Demo User
    // -------------------------------------------------------------------------
    private function seedDemoUser(): int
    {
        $email = 'demo@virratpos.test';

        $existing = DB::table('users')->where('email', $email)->first();
        if ($existing) {
            $this->command->line("   [skip] Demo user already exists (ID {$existing->id}).");
            return $existing->id;
        }

        $userId = DB::table('users')->insertGetId([
            'name'              => 'Demo Admin',
            'email'             => $email,
            'password'          => Hash::make('password'),
            'type'              => 'owner',
            'is_active'         => 1,
            'plan'              => 1,   // assumes a "Free" plan exists from PlansTableSeeder
            'plan_expire_date'  => now()->addYears(5)->toDateString(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $this->command->line("   [ok] Demo user created (ID {$userId}).");
        return $userId;
    }

    // -------------------------------------------------------------------------
    // Demo Store
    // -------------------------------------------------------------------------
    private function seedDemoStore(int $userId): int
    {
        $slug = 'demo-store';

        $existing = DB::table('stores')->where('slug', $slug)->first();
        if ($existing) {
            $this->command->line("   [skip] Demo store already exists (ID {$existing->id}).");
            return $existing->id;
        }

        $storeId = DB::table('stores')->insertGetId([
            'name'        => 'Demo Store',
            'slug'        => $slug,
            'tagline'     => 'Your best local shop',
            'description' => 'A sample store used for UI development and testing.',
            'email'       => 'store@virratpos.test',
            'phone'       => '+91 98765 43210',
            'address'     => '42 Main Street, Virrat City',
            'country'     => 'India',
            'city'        => 'Virrat',
            'zipcode'     => '110001',
            'currency'    => 'INR',
            'currency_symbol' => '₹',
            'is_active'   => 1,
            'created_by'  => $userId,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Link user → store
        DB::table('user_stores')->insert([
            'user_id'    => $userId,
            'store_id'   => $storeId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->line("   [ok] Demo store created (ID {$storeId}).");
        return $storeId;
    }

    // -------------------------------------------------------------------------
    // Product Categories
    // -------------------------------------------------------------------------
    private function seedProductCategories(int $storeId): array
    {
        $categories = [
            ['name' => 'Electronics',   'description' => 'Gadgets, phones, accessories'],
            ['name' => 'Clothing',       'description' => 'Apparel for men and women'],
            ['name' => 'Home & Kitchen', 'description' => 'Household essentials'],
        ];

        $ids = [];
        foreach ($categories as $cat) {
            $existing = DB::table('product_categories')
                ->where('store_id', $storeId)
                ->where('name', $cat['name'])
                ->first();

            if ($existing) {
                $ids[] = $existing->id;
                continue;
            }

            $ids[] = DB::table('product_categories')->insertGetId([
                'store_id'    => $storeId,
                'name'        => $cat['name'],
                'description' => $cat['description'],
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command->line('   [ok] ' . count($ids) . ' product categories ready.');
        return $ids;
    }

    // -------------------------------------------------------------------------
    // Product Tax
    // -------------------------------------------------------------------------
    private function seedProductTax(int $storeId): int
    {
        $existing = DB::table('product_taxes')
            ->where('store_id', $storeId)
            ->where('name', 'GST 18%')
            ->first();

        if ($existing) {
            return $existing->id;
        }

        return DB::table('product_taxes')->insertGetId([
            'store_id'   => $storeId,
            'name'       => 'GST 18%',
            'rate'       => 18.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // -------------------------------------------------------------------------
    // Products
    // -------------------------------------------------------------------------
    private function seedProducts(int $storeId, array $catIds, int $taxId): array
    {
        $products = [
            [
                'name'       => 'Wireless Earbuds Pro',
                'price'      => 1499.00,
                'qty'        => 50,
                'cat_index'  => 0, // Electronics
                'sku'        => 'DEMO-WEP-001',
                'description'=> 'True wireless earbuds with 30-hour battery life and active noise cancellation.',
            ],
            [
                'name'       => 'Smart Watch X1',
                'price'      => 3999.00,
                'qty'        => 30,
                'cat_index'  => 0, // Electronics
                'sku'        => 'DEMO-SWX-002',
                'description'=> 'Feature-packed smartwatch with health tracking and GPS.',
            ],
            [
                'name'       => 'Classic Cotton T-Shirt',
                'price'      => 349.00,
                'qty'        => 200,
                'cat_index'  => 1, // Clothing
                'sku'        => 'DEMO-CCT-003',
                'description'=> 'Comfortable everyday cotton tee available in 6 colours.',
            ],
            [
                'name'       => 'Slim Fit Jeans',
                'price'      => 999.00,
                'qty'        => 80,
                'cat_index'  => 1, // Clothing
                'sku'        => 'DEMO-SFJ-004',
                'description'=> 'Modern slim-fit denim jeans for casual and semi-formal wear.',
            ],
            [
                'name'       => 'Non-Stick Cookware Set',
                'price'      => 2499.00,
                'qty'        => 25,
                'cat_index'  => 2, // Home & Kitchen
                'sku'        => 'DEMO-NSC-005',
                'description'=> '5-piece non-stick cookware set with heat-resistant handles.',
            ],
        ];

        $ids = [];
        foreach ($products as $p) {
            $existing = DB::table('products')
                ->where('store_id', $storeId)
                ->where('sku', $p['sku'])
                ->first();

            if ($existing) {
                $ids[] = $existing->id;
                continue;
            }

            $ids[] = DB::table('products')->insertGetId([
                'store_id'    => $storeId,
                'category_id' => $catIds[$p['cat_index']] ?? $catIds[0],
                'tax_id'      => $taxId,
                'name'        => $p['name'],
                'sku'         => $p['sku'],
                'slug'        => Str::slug($p['name']) . '-' . Str::random(4),
                'description' => $p['description'],
                'price'       => $p['price'],
                'quantity'    => $p['qty'],
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command->line('   [ok] ' . count($ids) . ' products ready.');
        return $ids;
    }

    // -------------------------------------------------------------------------
    // Orders
    // -------------------------------------------------------------------------
    private function seedOrders(int $storeId, array $productIds): void
    {
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $names    = ['Ravi Kumar', 'Priya Sharma', 'Amit Patel', 'Sneha Iyer', 'Deepak Singh'];

        // Create 5 demo orders
        for ($i = 0; $i < 5; $i++) {
            $existing = DB::table('orders')
                ->where('store_id', $storeId)
                ->where('email', "customer{$i}@demo.test")
                ->first();

            if ($existing) {
                continue;
            }

            $productId = $productIds[$i % count($productIds)];
            $price     = DB::table('products')->where('id', $productId)->value('price') ?? 999;

            DB::table('orders')->insert([
                'store_id'       => $storeId,
                'product_id'     => $productId,
                'customer_name'  => $names[$i],
                'email'          => "customer{$i}@demo.test",
                'phone'          => '+91 900000000' . $i,
                'address'        => '0' . ($i + 1) . ' Demo Street, Test City',
                'status'         => $statuses[$i % count($statuses)],
                'quantity'       => rand(1, 3),
                'price'          => $price,
                'total_amount'   => $price,
                'payment_type'   => 'Demo',
                'payment_status' => 'paid',
                'created_at'     => now()->subDays(rand(0, 30)),
                'updated_at'     => now(),
            ]);
        }

        $this->command->line('   [ok] 5 demo orders ready.');
    }
}
