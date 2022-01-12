<?php

namespace App\Http\Controllers\Support\Billing;

use App\Models\Addworking\Billing\DeadlineType;
use App\Http\Requests\Support\Billing\DeadlineType\StoreDeadlineTypeRequest;
use App\Http\Requests\Support\Billing\DeadlineType\UpdateDeadlineTypeRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Support\Billing\DeadlineTypeRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;

class DeadlineTypeController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(DeadlineTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $items = $this->getPaginatorFromRequest($request);

        return view('support.billing.deadline_type.index', @compact('items'));
    }

    public function create()
    {
        $deadline_type = $this->repository->make();

        return view('support.billing.deadline_type.create', @compact('deadline_type'));
    }

    public function store(StoreDeadlineTypeRequest $request)
    {
        $deadline_type = $this->repository->createFromRequest($request);

        return $this->redirectWhen($deadline_type->exists, $deadline_type->routes->show);
    }

    public function show(DeadlineType $deadline_type)
    {
        return view('support.billing.deadline_type.show', @compact('deadline_type'));
    }

    public function edit(DeadlineType $deadline_type)
    {
        return view('support.billing.deadline_type.edit', @compact('deadline_type'));
    }

    public function update(UpdateDeadlineTypeRequest $request, DeadlineType $deadline_type)
    {
        $deadline_type = $this->repository->updateFromRequest($request, $deadline_type);

        return $this->redirectWhen($deadline_type->exists, $deadline_type->routes->show);
    }

    public function destroy(DeadlineType $deadline_type)
    {
        $deleted = $this->repository->delete($deadline_type);

        return $this->redirectWhen($deleted, $deadline_type->routes->index);
    }
}
