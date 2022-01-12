<?php

namespace App\Http\Controllers\Everial\Mission;

use App\Http\Requests\Everial\Mission\Referential\StoreReferentialRequest;
use App\Http\Requests\Everial\Mission\Referential\UpdateReferentialRequest;
use App\Models\Everial\Mission\Referential;
use App\Repositories\Everial\Mission\ReferentialRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReferentialController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(ReferentialRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('index', Referential::class);

        $items = $this->getPaginatorFromRequest($request);

        return view('everial.mission.referential.index', @compact('items'));
    }

    public function create()
    {
        $this->authorize('create', Referential::class);

        $referential = $this->repository->factory();

        return view('everial.mission.referential.create', @compact('referential'));
    }

    public function store(StoreReferentialRequest $request)
    {
        $referential = $this->repository->createFromRequest($request);

        return redirect_when($referential->exists, $referential->routes->show);
    }

    public function show(Referential $referential)
    {
        $this->authorize('show', $referential);

        return view('everial.mission.referential.show', @compact('referential'));
    }

    public function edit(Referential $referential)
    {
        $this->authorize('create', $referential);

        return view('everial.mission.referential.edit', @compact('referential'));
    }

    public function update(UpdateReferentialRequest $request, Referential $referential)
    {
        $this->authorize('update', $referential);

        $referential = $this->repository->updateFromRequest($request, $referential);

        return redirect_when($referential->exists, $referential->routes->show);
    }

    public function destroy(Referential $referential)
    {
        $this->authorize('destroy', $referential);

        $deleted = $referential->delete();

        return redirect_when($deleted, $referential->routes->index);
    }
}
