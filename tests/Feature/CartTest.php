<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Customer;
use App\Product;
use App\Cart;

class CartTest extends TestCase
{
    /** @test */
    public function an_item_can_be_added_to_cart()
    {
        $prod = Product::find(240);

        $response = $this->post('/cart', [
            'item_code'     => $prod->item_code,
            'item_name'     => $prod->item_name,
            'quantity'      => '2',
            'price'         => $prod->price
        ]);

        $response->assertOk();
        $this->assertCount(1, Cart::all());
    }

    /** @test */
    public function a_quantity_is_required()
    {
        $prod = Product::first();

        $response = $this->post('/cart', [
            'item_code'     => $prod->item_code,
            'item_name'     => $prod->item_name,
            'quantity'      => '',
            'price'         => $prod->price
        ]);

        $response->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function a_quantity_can_be_updated()
    {
        $cart = Cart::first();

        $this->patch('/cart/' . $cart->id, [
            'quantity' => '10'
        ]);

        $this->assertEquals('10', Cart::first()->quantity);
    }

    /** @test */
    public function an_item_can_be_deleted_from_cart()
    {
        $cart = Cart::first();

        $this->delete('/cart/' . $cart->id);

        $this->assertCount(0, Cart::all());
    }

    /** @test */
    public function customer_can_remove_all_items_from_cart()
    {
        $cust = Customer::first();

        $this->delete('/cart/remove_all_items/' . $cust->id);
    }
}
