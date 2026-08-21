<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Store;
use App\Models\Product;

class StorefrontThemeTest extends TestCase
{
    /**
     * Test storefront home page rendering.
     */
    public function test_storefront_homepage_renders_successfully()
    {
        $store = Store::where('slug', 'my-store')->first();
        if (!$store) {
            $this->markTestSkipped('my-store slug not found.');
        }

        $response = $this->get('/store/my-store');
        $response->assertStatus(200);
        $response->assertSee('Premium Minimalist Luxury');
    }

    /**
     * Test storefront product detail page rendering.
     */
    public function test_storefront_product_detail_renders_successfully()
    {
        $product = Product::first();
        if (!$product) {
            $this->markTestSkipped('No products found in database.');
        }

        $response = $this->get('/store/my-store/product/' . $product->id);
        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /**
     * Test storefront cart page rendering.
     */
    public function test_storefront_cart_renders_successfully()
    {
        $response = $this->get('/user-cart-item/my-store/cart');
        $response->assertStatus(200);
        $response->assertSee('Your cart is empty');
    }

    /**
     * Test storefront cart addition, quantity updates, and item removal flow.
     */
    public function test_storefront_cart_addition_and_qty_update_and_removal_flow()
    {
        $product = Product::first();
        if (!$product) {
            $this->markTestSkipped('No products found in database.');
        }

        // 1. Add product to cart via AJAX POST request
        $response = $this->post('/add-to-cart/' . $product->id . '/my-store/0', [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'Success']);

        // 2. Fetch the session cart timestamp key
        $cart = session()->get('my-store');
        $this->assertNotEmpty($cart);
        $this->assertNotEmpty($cart['products']);
        $cartKeys = array_keys($cart['products']);
        $cartKey = $cartKeys[0];

        // 3. Adjust product quantity in cart (AJAX POST)
        // Path: user-product_qty/{slug?}/product/{id}/{variant_name?}
        // mapped in method to request, product_id, slug, key
        $qtyResponse = $this->post('/user-product_qty/' . $product->id . '/product/my-store/' . $cartKey, [
            'product_qty' => 3
        ], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);
        $qtyResponse->assertStatus(200);

        // 4. Remove product from cart (DELETE request)
        $delResponse = $this->delete('/delete_cart_item/my-store/product/' . $product->id . '/0');
        $delResponse->assertStatus(302); // Redirect back to cart page
    }

    /**
     * Test storefront wishlist flow.
     */
    public function test_storefront_wishlist_flow()
    {
        $product = Product::first();
        if (!$product) {
            $this->markTestSkipped('No products found in database.');
        }

        // Add to wishlist
        $response = $this->post('/store/my-store/addtowishlist/' . $product->id, [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);
        $response->assertStatus(200);
    }

    /**
     * Test storefront search and category filtering.
     */
    public function test_storefront_search_and_category_filtering()
    {
        // 1. Search products
        $searchResponse = $this->get('/store/my-store/categorie/Start shopping?search_data=Test');
        $searchResponse->assertStatus(200);

        // 2. Category filtering
        $catResponse = $this->get('/store/my-store/categorie/Start shopping');
        $catResponse->assertStatus(200);
    }

    /**
     * Verify theme isolation by switching active theme in DB.
     */
    public function test_theme_isolation_behavior()
    {
        $store = Store::where('slug', 'my-store')->first();
        if (!$store) {
            $this->markTestSkipped('my-store slug not found.');
        }

        // 1. Switch active theme to theme1
        $store->theme_dir = 'theme1';
        $store->store_theme = 'theme1-v1';
        $store->save();

        // Visit storefront homepage and assert theme1 works (default layout, no theme11 custom style marker)
        $response1 = $this->get('/store/my-store');
        $response1->assertStatus(200);
        $response1->assertDontSee('Premium Minimalist Luxury');

        // 2. Switch active theme to theme11
        $store->theme_dir = 'theme11';
        $store->store_theme = 'theme11-v1';
        $store->save();

        // Visit storefront homepage and assert theme11 custom style marker is present
        $response2 = $this->get('/store/my-store');
        $response2->assertStatus(200);
        $response2->assertSee('Premium Minimalist Luxury');
    }
}
