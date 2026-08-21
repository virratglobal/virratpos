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
     * Test storefront cart addition and viewing checkout flow.
     */
    public function test_storefront_cart_addition_flow()
    {
        $product = Product::first();
        if (!$product) {
            $this->markTestSkipped('No products found in database.');
        }

        // Add product to cart via AJAX POST request
        // Parameters are: slug/id/variant_id mapped to product_id/slug/variant_id in controller
        $response = $this->post('/add-to-cart/' . $product->id . '/my-store/0', [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'Success'
        ]);

        // Visit the cart page and verify the product name is displayed
        $cartResponse = $this->get('/user-cart-item/my-store/cart');
        $cartResponse->assertStatus(200);
        $cartResponse->assertSee($product->name);
        $cartResponse->assertSee('Proceed to checkout');
    }
}
