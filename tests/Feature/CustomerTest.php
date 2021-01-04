<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Customer;

class CustomerTest extends TestCase
{
    /** @test */
    public function a_customer_can_be_created()
    {
        $response = $this->post('/customer', [
            'first_name'    => 'Joseph Vincent',
            'last_name'     => 'Coquilla',
            'email'         => 'joseph.coquilla@email.com',
            'phone'         => '09987654321',
            'barangay'      => '1',
            'street'        => 'Nograles Ave.',
            'street2'       => '',
            'city'          => 'Davao City',
            'province'      => 'Davao Del Sur',
            'zip'           => '8000'
        ]);

        $response->assertOk();
        $this->assertCount(1, Customer::all());
    }

    /** @test */
    public function all_fields_are_required_except_street2()
    {
        $response = $this->post('/customer', [
            'first_name'    => '',
            'last_name'     => '',
            'email'         => '',
            'phone'         => '',
            'barangay'      => '',
            'street'        => '',
            'street2'       => '',
            'city'          => '',
            'province'      => '',
            'zip'           => ''
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name', 'email', 'phone', 'barangay', 'street', 'street2', 'city', 'province', 'zip']);
    }

    /** @test */
    public function a_customer_info_can_be_updated()
    {
        $cust = Customer::first();

        $this->patch('/customer/' . $cust->id, [
            'first_name'    => 'Joseph Vincent',
            'last_name'     => 'Coquilla',
            'email'         => 'joseph.coquilla@email.com',
            'phone'         => '09123456789',
            'barangay'      => 'Barangay 40-D Poblacion',
            'street'        => 'Nograles Ave.',
            'street2'       => '',
            'city'          => 'Davao City',
            'province'      => 'Davao Del Sur',
            'zip'           => '8000'
        ]);

        $this->assertEquals('09123456789', Customer::first()->phone);
    }

    /** @test */
    public function a_customer_can_be_deleted()
    {
        $cust = Customer::first();

        $this->delete('/customer/' . $cust->id);

        $this->assertCount(0, Customer::all());
    }

    /** @test */
    public function all_users_can_be_deleted()
    {
        $this->delete('/customer/delete_all');

        $this->assertCount(0, Customer::all());
    }
}
