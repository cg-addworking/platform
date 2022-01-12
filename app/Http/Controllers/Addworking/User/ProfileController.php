<?php

namespace App\Http\Controllers\Addworking\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Addworking\User\User;
use App\Models\Addworking\Contract\Contract;
use App\Jobs\Addworking\User\User\UpdateProfilePicture;
use App\Http\Requests\Addworking\Profile\UpdateRequest;

class ProfileController extends Controller
{
    public function index()
    {
        $this->authorize('indexProfile', User::class);

        $address = null;
        $phones = null;

        if ($enterprise = Auth::user()->enterprises()->first()) {
            $address = $enterprise->addresses()->first();
            $phones = $enterprise->phoneNumbers()->take(2)->get();
        }

        $enterprises = Auth::user()->enterprises;

        return view('addworking.user.profile.index', @compact('enterprise', 'address', 'phones', 'enterprises'));
    }

    public function edit()
    {
        $this->authorize('editProfile', User::class);

        $user = Auth::user();

        return view('addworking.user.profile.edit', @compact('user'));
    }

    public function update(UpdateRequest $request)
    {
        $this->authorize('storeProfile', User::class);

        $user = Auth::user();

        $user->update($request->only(
            'gender',
            'firstname',
            'lastname'
        ));

        foreach ($request->input('address', []) as $id => $address) {
            $user->enterprise->addresses()->find($id)->update(['country' => 'fr'] + $address);
        }

        foreach ($request->input('phones', []) as $id => $phoneNumber) {
            $user->phoneNumbers()->find($id)->update($phoneNumber);
        }

        if ($request->has('picture')) {
            $file = $this->dispatchNow(new UpdateProfilePicture($request->user(), $request->file('picture')));
        }

        return redirect()->route('profile')->with('status', [
            'class' => 'success',
            'icon' => 'check',
        ]);
    }

    public function editEmail()
    {
        $this->authorize('editEmailProfile', User::class);

        $user = Auth::user();

        return view('addworking.user.profile.edit_email', @compact('user'));
    }

    public function storeEmail(Request $request)
    {
        $this->authorize('storeEmailProfile', User::class);

        $user = Auth::user();

        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:addworking_user_users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect()
                ->route('profile.edit_email')
                ->withErrors(['password' => __('profile.profile.save_email_invalid_password')])
                ->withInput();
        }

        $user->update($request->only('email'));

        return redirect()->route('profile')->with('status', [
            'class' => 'success',
            'icon' => 'check',
        ]);
    }

    public function editPassword()
    {
        $this->authorize('editPasswordProfile', User::class);

        $user = Auth::user();

        return view('addworking.user.profile.edit_password', @compact('user'));
    }

    public function storePassword(Request $request)
    {
        $this->authorize('storePasswordProfile', User::class);

        $user = Auth::user();

        $this->validate($request, [
            'password'     => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (! Hash::check($request->input('password'), $user->password)) {
            return redirect()
                ->route('profile.edit_password')
                ->withErrors(['password' => __('profile.profile.save_email_invalid_password')]);
        }

        $user->update(['password' => Hash::make($request->input('new_password'))]);

        return redirect()->route('dashboard')->with('status', [
            'class' => 'success',
            'icon' => 'check',
        ]);
    }

    public function storeAccountType(Request $request)
    {
        $this->authorize('storeAccountTypeProfile', User::class);

        abort(501);
    }

    public function customers()
    {
        $this->authorize('customersProfile', User::class);

        $items = auth()->user()->enterprise->customers;

        return view('addworking.user.profile.customers', @compact('items'));
    }
}
