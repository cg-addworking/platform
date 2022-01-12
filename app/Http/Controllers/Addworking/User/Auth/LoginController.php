<?php

namespace App\Http\Controllers\Addworking\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('addworking.user.auth.login');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->is_active) {
            Auth::logout();

            $status  = [
                'class'   => "warning",
                'icon'    => "ban",
                'message' => "Votre compte est désactivé, veuillez contacter contact@addworking.com",
            ];

            return redirect()->back()->with(@compact('status'));
        }

        if (!$user instanceof User) {
            return;
        }

        if (Session::has('redirectAfterLogin')) {
            return redirect()->to(Session::get('redirectAfterLogin'));
        }
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        if (env('LOGIN_PASSWORD_CHECK', true) == false) {
            $this->guard()->login(
                User::fromEmail(strtolower($request->input('email')))
            );
            return true;
        }

        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials()
    {
        $credentials = request()->only($this->username(), 'password');

        if (isset($credentials[$this->username()])) {
            $credentials[$this->username()] = strtolower($credentials[$this->username()]);
        }

        return $credentials;
    }
}
