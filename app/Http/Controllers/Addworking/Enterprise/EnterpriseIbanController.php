<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Enterprise\Iban\StoreIbanRequest;
use App\Mail\IbanValidation;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\IbanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class EnterpriseIbanController extends Controller
{
    protected $repository;

    public function __construct(IbanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', Iban::class);

        $iban = app()->environment('local')
            ? factory(Iban::class)->make()
            : new Iban;

        $iban->enterprise()->associate($enterprise);

        return view('addworking.enterprise.iban.create', @compact('enterprise', 'iban'));
    }

    public function store(Enterprise $enterprise, StoreIbanRequest $request)
    {
        $iban = $this->repository->createFromRequest($request, $enterprise);

        return redirect_when(
            $iban->exists,
            route('enterprise.iban.show', [$enterprise, $iban]),
            "Un mail vient de vous être envoyé afin de valider votre nouvel IBAN."
        );
    }

    public function show(Enterprise $enterprise, Iban $iban)
    {
        $this->authorize('show', $iban);

        return view('addworking.enterprise.iban.show', @compact('enterprise', 'iban'));
    }

    public function update(Enterprise $enterprise, Iban $iban, Request $request)
    {
        abort(501); // Not Implemented
    }

    public function destroy(Enterprise $enterprise, Iban $iban)
    {
        $this->authorize('destroy', $iban);

        $deleted = $iban->delete();

        return redirect_when($deleted, route('enterprise.show', $enterprise));
    }

    public function confirm(Enterprise $enterprise, Iban $iban, Request $request)
    {
        $user = User::loginFromIbanValidationToken($token = $request->input('token'));

        $this->authorize('confirm', $iban);

        $confirmed = $this->repository->confirm($iban, $user);

        return redirect()->route('dashboard')->with(
            $confirmed ? success_status("Nouvel IBAN confirmé") : error_status("Nouvel IBAN non confirmé")
        );
    }

    public function cancel(Enterprise $enterprise, Iban $iban, Request $request)
    {
        $user = User::loginFromIbanValidationToken($token = $request->input('token'));

        $this->authorize('cancel', $iban);

        $this->repository->cancel($iban, $user);

        return redirect()->route('dashboard')->with(success_status("Modification IBAN annulée"));
    }

    public function resend(Enterprise $enterprise, Iban $iban)
    {
        $this->authorize('resend', $iban);

        $this->repository->sendValidationEmail($iban, auth()->user());

        return redirect()->route('dashboard')->with(success_status());
    }
}
