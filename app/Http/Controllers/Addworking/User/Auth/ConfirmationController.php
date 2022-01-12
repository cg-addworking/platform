<?php

namespace App\Http\Controllers\Addworking\User\Auth;

use App\Events\UserConfirmationResend;
use App\Http\Controllers\Controller;
use App\Models\Addworking\User\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class ConfirmationController extends Controller
{
    public function confirm($token)
    {
        try {
            $user = User::whereConfirmationToken($token)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('dashboard')->with(
                error_status("Le jeton de confirmation a expiré ou est invalide")
            );
        }

        Auth::setUser($user);
        $user->forgetConfirmationToken()->confirm();

        return redirect()->route('dashboard')->with(
            success_status(__('messages.confirmation.account_confirmed'))
        );
    }

    public function resend()
    {
        Event::dispatch(new UserConfirmationResend(Auth::user()));

        return redirect()->route('dashboard')->with(
            success_status(__('messages.confirmation.mail_resent'))
        );
    }

    public function confirmation()
    {
        if (!Auth::check()) {
            return view('addworking.user.auth.confirmation');
        }

        if (Auth::user()->isConfirmed()) {
            return redirect()->route('dashboard');
        }

        return view('addworking.user.auth.confirmation');
    }

    public function force()
    {
        if (!in_array(App::environment(), ['local', 'staging'])) {
            abort(403);
        }

        Auth::user()->confirm();

        return redirect()->route('dashboard');
    }
}
