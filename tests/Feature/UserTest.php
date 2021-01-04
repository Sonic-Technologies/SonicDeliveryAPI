<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\User;

class UserTest extends TestCase
{
    /** @test */
    public function a_user_can_be_created()
    {
        $response = $this->post('/user', [
            'name'                  => 'Jayvee',
            'email'                 => 'jayvee@email.com',
            'password'              => '123123123',
            'password_confirmation' => '123123123'
        ]);

        $response->assertOk();
    }

    /** @test */
    public function a_password_confirmation_is_required()
    {
        $response = $this->post('/user', [
            'name'                  => 'Jayvee3',
            'email'                 => 'jayvee3@email.com',
            'password'              => '123123123',
            'password_confirmation' => ''
        ]);

        $response->assertSessionHasErrorsIn('password_confirmation');
    }

    /** @test */
    public function a_name_and_email_is_required()
    {
        $response = $this->post('/user', [
            'name'                  => '',
            'email'                 => '',
            'password'              => '123123123',
            'password_confirmation' => '123123123'
        ]);

        $response->assertSessionHasErrors(['name', 'email']);
    }

    /** @test */
    public function a_user_can_update_an_info()
    {
        $user = User::first();

        $this->patch('/user/' . $user->id, [
            'name'  => 'Joseph Vincent',
            'email' => 'tuttifrutti@email.com'
        ]);

        $this->assertEquals('Joseph Vincent', User::first()->name);
        $this->assertEquals('tuttifrutti@email.com', User::first()->email);
    }

    /** @test */
    public function a_user_can_update_a_password()
    {
        $newPassword = '0987654321';
        
        $user = User::first();

        $response = $this->patch('/user/' . $user->id, [
            'name'                      => 'Joseph Vincent',
            'email'                     => 'tuttifrutti@email.com',
            'password'                  => $newPassword,
            'password_confirmation'     => $newPassword
        ]);

        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    /** @test */
    public function a_user_can_be_delete()
    {
        $user = User::find(2);

        $response = $this->delete('/user/' . $user->id);

        $response->assertSuccessful();
    }

    /** @test */
    public function all_user_can_be_deleted()
    {
        $response = $this->delete('/user/remove_all_user');

        $response->assertSuccessful();
    }
}
