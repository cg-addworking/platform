<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Site;
use App\Repositories\Addworking\Enterprise\SiteRepository;
use Illuminate\Http\Request;

class SitePhoneNumberController extends Controller
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
    public function __construct(SiteRepository $repository)
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
    public function create(Enterprise $enterprise, Site $site)
    {
        $this->authorize('edit', $site);

        return view('addworking.enterprise.site.phone_number.create', @compact('enterprise', 'site'));
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
    public function store(Request $request, Enterprise $enterprise, Site $site)
    {
        $this->authorize('edit', $site);

        $saved = $this->repository->attachPhoneNumberForSiteFromRequest($request, $site);

        return redirect_when($saved->exists, $site->routes->show);
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
    public function destroy(Enterprise $enterprise, Site $site, PhoneNumber $phone_number)
    {
        $this->authorize('removePhoneNumbers', $site);

        $detached = $phone_number->sites()->detach($site);

        return redirect_when($detached, $site->routes->show);
    }
}
