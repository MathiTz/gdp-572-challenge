<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function onlyLoggedUserCanGetInformation()
    {
        $response = $this->get('api/auth/user')->assertRedirect('/api/unauthorized');
    }

    /** @test */
    public function authenticatedUsersCanGetUsersInformation()
    {
        $this->actingAs(factory(User::class)->create());

        $response = $this->get('api/auth/user')->assertOk();
    }

    /** @test */
    public function creatingUserAfterAuthenticated()
    {
        $this->actingAsAdmin();

        $response = $this
            ->post('/api/auth/user', $this->data())->assertStatus(201);
    }

    /** @test */
    public function emailIsUnique()
    {
        $this->actingAsAdmin();

        $response = $this
            ->post('/api/auth/user', array_merge($this->data(), ['email'=>'admin@atlantico.com']));

        $response->assertStatus(400);
    }

    public function actingAsAdmin()
    {
        $this->actingAs(factory(User::class)->create(['email'=>'admin@atlantico.com']));
    }

    private function data()
    {
        return [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '123456'
        ];
    }
}
