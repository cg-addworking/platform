<?php

namespace Tests\Feature\Addworking\User;

use App\Models\Addworking\User\User;
use App\Notifications\Addworking\User\ManuallyResetedPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class ManualPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function testManualPasswordReset()
    {
        Notification::fake();

        $user = factory(User::class)->create();
        $user->manualPasswordReset();

        Notification::assertSentTo($user, ManuallyResetedPasswordNotification::class);

        $password = Notification::sent($user, ManuallyResetedPasswordNotification::class)->first()->password;

        $response = $this->from('/login')->post('/login', [
            'email'    => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($user);
    }
}
