<?php

namespace App\Http\Controllers\Addworking\Common;

use App\Http\Requests\Addworking\SaveAddressRequest;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * AddressController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('verify_account_type');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Address::class);

        if (auth()->user()->isSupport()
        ) {
            $addresses = Address::all();
        } else {
            $addresses = Auth::user()->enterprise->addresses;
        }

        return view('addworking.common.address.index', @compact('addresses'));
    }

    /**
     * @param Address $address
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Address $address)
    {
        $this->authorize('show', $address);

        return view('addworking.common.address.view', @compact('address'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {

        $this->authorize('create', Address::class);

        $address = new Address;

        if (app()->environment('local')) {
            $address = factory(Address::class)->make();
        }

        return view('addworking.common.address.edit', @compact('address'));
    }

    /**
     * @param Address $address
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Address $address)
    {
        $this->authorize('edit', $address);

        return view('addworking.common.address.edit', @compact('address'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(SaveAddressRequest $request)
    {
        $address = $request->has('address.id')
            ? Address::find($request->input('address.id'))
            : new Address;

        $address->fill($request->input('address'));

        $saved = transaction(function () use ($request, $address) {
            if (!$address->save()) {
                return false;
            }

            if ($request->has('enterprise.id')) {
                Enterprise::find($request->input('enterprise.id'))->attachAddress($address);
            }

            return true;
        });

        return $saved
            ? redirect()->route('address.view', $address)->with(success_status(
                __('messages.address.save_success')
            ))
            : redirect()->back()->with(error_status(
                "Impossible d'enregistrer l'adresse"
            ));
    }

    /**
     * @param Address $address
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Address $address)
    {
        $this->authorize('destroy', $address);

        $deleted = $address->delete();

        return $deleted
            ? redirect()->back()->with(success_status(
                __('messages.address.delete_success')
            ))
            : redirect()->back()->with(error_status(
                "Impossible de supprimer l'adresse"
            ));
    }

    public function detach(Address $address, Enterprise $enterprise)
    {
        $this->authorize('detach', $address);

        $enterprise->addresses()->detach($address);

        return redirect()->back()->with(success_status(
            __('messages.address.delete_success')
        ));
    }
}
