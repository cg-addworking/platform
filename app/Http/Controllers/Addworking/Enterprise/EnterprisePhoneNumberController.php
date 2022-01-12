<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Enterprise\StoreEnterprisePhoneNumberRequest;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use Illuminate\Http\Request;

class EnterprisePhoneNumberController extends Controller
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param EnterpriseRepository $repository
     */
    public function __construct(EnterpriseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(501);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Enterprise $enterprise)
    {
        $this->authorize('edit', $enterprise);

        return view('addworking.enterprise.phone_number.create', @compact('enterprise'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Attach a new phone_number to the given enterprise.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreEnterprisePhoneNumberRequest $request, Enterprise $enterprise)
    {
        $this->authorize('edit', $enterprise);

        $saved = $this->repository->attachPhoneNumberFromRequest($request, $enterprise);

        return redirect_when($saved->exists, route('enterprise.show', @compact('enterprise')));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(501);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(501);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Enterprise $enterprise
     * @param  PhoneNumber $phone_number
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enterprise $enterprise, PhoneNumber $phone_number)
    {
        $this->authorize('removePhoneNumbers', $enterprise);

        $detached = $phone_number->enterprises()->detach($enterprise);
        return redirect_when($detached == 1, route('enterprise.show', @compact('enterprise')));
    }
}
