<?php

namespace App\Http\Controllers\Addworking\User\Auth;

use App\Events\UserRegistration;
use App\Http\Controllers\Controller;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('addworking.user.auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validator(array $data)
    {
        $rules = [
            'gender' => ['required', Rule::in(['male', 'female'])],
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:addworking_user_users',
            'password' => 'required|string|min:6|confirmed',
            'tos_accepted' => 'required',
            'phone_number' => 'required|phone:FR,BE,DE',
        ];

        if (Config::get('recaptcha.enabled')) {
            $rules += [recaptchaFieldName() => recaptchaRuleName()];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @deprecated v0.32.2 this method should use the UserRepository
     *
     * @param  array $data
     * @return \App\Models\Addworking\User\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'gender' => $data['gender'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'tos_accepted' => true,
        ]);

        $phone_number = PhoneNumber::fromNumber($data['phone_number']);

        if (is_null($phone_number)) {
            $phone_number = PhoneNumber::create(['number' => $data['phone_number']]);
        }
        
        $user->phoneNumbers()->attach($phone_number, ['note' => "Pro"]);
        
        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    public static function registered(Request $request, $user)
    {
        event(new UserRegistration($user));

        return redirect()
            ->route('dashboard')
            ->with(success_status(__('user.register.success', ['name' => $user->name])));
    }
}
