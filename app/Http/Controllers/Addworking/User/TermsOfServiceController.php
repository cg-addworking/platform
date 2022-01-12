<?php

namespace App\Http\Controllers\Addworking\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\User\UpdateTosAcceptedUser;

class TermsOfServiceController extends Controller
{
    public function update(UpdateTosAcceptedUser $request)
    {
        $request->user()->update(['tos_accepted' => true]);

        return redirect()->route('dashboard');
    }

    public function show()
    {
        return view('addworking.user.terms_of_use.show');
    }
}
