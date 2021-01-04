<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;

class ProductTest extends TestCase
{
    /** @test */
    public function a_product_can_be_added()
    {
        $response = $this->post('/product', [
            'item_code'    => '1011',
            'item_name'    => 'Mentos',
            'inventory'    => '124',
            'price'        => '48.99',
            'brand'        => 'Mentos',
            'category'     => 'Candy',
            'photo'        => 'filepath/mentos.jpg',
            'status'       => 'Active'
        ]);

        $response->assertOk();
    }

    /** @test */
    public function all_fields_required_except_photo()
    {
        $response = $this->post('/product', [
            'item_code'    => '',
            'item_name'    => '',
            'inventory'    => '',
            'price'        => '',
            'brand'        => '',
            'category'     => '',
            'photo'        => '',
            'status'       => ''
        ]);

        $response->assertSessionHasErrors(['item_code', 'item_name', 'inventory', 'price', 'brand', 'category', 'status']);
    }

    /** @test */
    public function a_product_can_be_updated()
    {
        $prod = Product::find(9005);

        $this->patch('/product/' . $prod->id, [
            'item_code'    => '1011',
            'item_name'    => 'Mentos',
            'inventory'    => '1001',
            'price'        => '48.99',
            'brand'        => 'Mentos',
            'category'     => 'Candy',
            'photo'        => 'filepath/mentos.jpg',
            'status'       => 'Active'
        ]);

        $this->assertEquals('1001', Product::find(9005)->inventory); 
    }

    /** @test */
    public function a_product_can_be_deleted()
    {
        $prod = Product::find(9008);

        $this->delete('/product/' . $prod->id);
    }

    /** @test */
    public function all_products_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->delete('/product/delete_all');

        $this->assertCount(0, Product::all());
    }
}
