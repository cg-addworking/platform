<?php

namespace Tests\Feature\Addworking\User;

use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginView()
    {
        $response = $this->get('/login');
        $response->assertSuccessful();
        $response->assertViewIs('addworking.user.auth.login');
    }

    public function testLoginSucceeds()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make($password = Str::random(10))
        ]);

        $response = $this->from('/login')->post('/login', [
            'email'    => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($user);
    }

    public function testLoginFails()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make($password = Str::random(10))
        ]);

        $response = $this->from('/login')->post('/login', [
            'email'    => $user->email,
            'password' => "invalid-password",
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(Session::hasOldInput('email'));
        $this->assertFalse(Session::hasOldInput('password'));
        $this->assertGuest();
    }
}
