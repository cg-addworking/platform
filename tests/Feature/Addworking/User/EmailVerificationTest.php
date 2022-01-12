<?php

namespace Tests\Feature\Addworking\User;

use App\Events\UserConfirmationResend;
use App\Events\UserRegistration;
use App\Mail\Confirmation;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function sendVerificationEmail()
    {
        Mail::fake();

        $user = factory(User::class)->create();

        $this->assertFalse($user->isConfirmed());
        $this->assertEmpty($user->confirmation_token);

        Event::dispatch(new UserRegistration($user));

        $this->assertNotEmpty($user->confirmation_token);

        Mail::assertSent(Confirmation::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        return Mail::sent(Confirmation::class)->first();
    }

    public function testEmailVerificationCallbackUrl()
    {
        $mail = $this->sendVerificationEmail();

        $this->assertConfirmationUrlRedirectsToDashboard($mail->url);
        $this->assertUserConfirmedAndAuthenticated($mail->user->fresh());

        // the confirmation link should only be usable once!
        $response = $this->get($mail->url);
        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('status.class', 'danger');
    }

    public function testResendEmailVerification()
    {
        $mail = $this->sendVerificationEmail();

        $user = $mail->user;
        $first_mail = $mail;
        $first_token = $user->confirmation_token;

        Event::dispatch(new UserConfirmationResend($user));

        $user = $user->fresh();

        // a new token should be generated on confirmation resend
        $this->assertNotEmpty($user->confirmation_token);
        $this->assertTrue($user->confirmation_token != $first_token);

        Mail::assertSent(Confirmation::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        $second_mail = Mail::sent(Confirmation::class)[1];

        // the previous confirmation link should be obsolete
        $this->assertConfirmationUrlFails($first_mail->url);

        $this->assertTrue($second_mail->url != $first_mail->url);
        $this->assertConfirmationUrlRedirectsToDashboard($second_mail->url);
        $this->assertUserConfirmedAndAuthenticated($second_mail->user->fresh());

        // the new confirmation link should only be usable once!
        $this->assertConfirmationUrlFails($second_mail->url);
    }

    public function assertUserConfirmedAndAuthenticated(User $user)
    {
        $this->assertAuthenticatedAs($user);
        $this->assertTrue($user->isConfirmed());
        $this->assertEmpty($user->confirmation_token);
    }

    public function assertConfirmationUrlRedirectsToDashboard(string $url)
    {
        $response = $this->get($url);
        $response->assertRedirect('/dashboard');
        $response->assertSessionHasNoErrors();
    }

    public function assertConfirmationUrlFails(string $url)
    {
        $response = $this->get($url);
        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('status.class', 'danger');
    }
}
