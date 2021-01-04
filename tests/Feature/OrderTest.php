<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Order;

class OrderTest extends TestCase
{
    /** @test */
    public function an_order_can_be_created()
    {
        $response = $this->post('/order', [
            'barangay' => '1',
        ]);

        $response->assertOk();
    }

    /** @test */
    public function a_barangay_is_needed()
    {
        $response = $this->post('/order', [
            'barangay' => '',
        ]);

        $response->assertSessionHasErrors('barangay');
    }

    /** @test */
    public function an_admin_can_update_an_order()
    {
        $order = Order::first();

        $this->patch('/order/' . $order->id, [
            'status' => 'confirmed'
        ]);

        $this->assertEquals('confirmed', Order::first()->status);
    }
}
