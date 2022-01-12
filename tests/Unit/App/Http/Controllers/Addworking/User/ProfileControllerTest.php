<?php

namespace Tests\Unit\App\Http\Controllers\Addworking\User;

use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStorePassword()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make("foobar"),
        ]);

        $response = $this->actingAs($user)->post(route('profile.save_password'), [
            'password' => "foobar",
            'new_password' => "password",
            'new_password_confirmation' => "password",
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertRedirect(route('dashboard'));

        $this->assertTrue(
            Hash::check('password', $user->fresh()->password),
            "User's password should have been changed"
        );
    }

    public function testStorePasswordWithWrongPassword()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make("foobar"),
        ]);

        $response = $this->actingAs($user)->post(route('profile.save_password'), [
            'password' => "foobarbaz",
            'new_password' => "password",
            'new_password_confirmation' => "password",
        ]);

        $response->assertSessionHasErrors();

        $this->assertFalse(
            Hash::check('password', $user->fresh()->password),
            "User's password should have been changed"
        );
    }
}
