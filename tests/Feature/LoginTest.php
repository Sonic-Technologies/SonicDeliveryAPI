<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function an_admin_can_login()
    {
        $credentials = [
            'email'     => 'jayvee@email.com',
            'password'  => '123123123'
        ];

        $response = $this->post('/login', $credentials);

        $this->assertAuthenticated($guard = null);
        $this->assertCredentials($credentials, $guard = null);
    }

    /** @test */
    public function a_valid_credentials_must_be_entered()
    {
        $credentials = [
            'email'     => 'jayvee@email.com',
            'password'  => '123123123123123123'
        ];

        $response = $this->post('/login', $credentials);

        $this->assertInvalidCredentials($credentials, $guard = null);
    }

    /** @test */
    public function an_admin_can_logout()
    {
        $response = $this->get('/logout');

        $response->assertSuccessful();
    }
}
