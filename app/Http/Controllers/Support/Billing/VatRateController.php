<?php

namespace App\Http\Controllers\Support\Billing;

use App\Models\Addworking\Billing\VatRate;
use App\Http\Requests\Support\Billing\VatRate\StoreVatRateRequest;
use App\Http\Requests\Support\Billing\VatRate\UpdateVatRateRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Addworking\Billing\VatRateRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;

class VatRateController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(VatRateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $items = $this->getPaginatorFromRequest($request);

        return view('support.billing.vat_rate.index', @compact('items'));
    }

    public function create()
    {
        $vat_rate = $this->repository->make();

        return view('support.billing.vat_rate.create', @compact('vat_rate'));
    }

    public function store(StoreVatRateRequest $request)
    {
        $vat_rate = $this->repository->createFromRequest($request);

        return $this->redirectWhen($vat_rate->exists, $vat_rate->routes->show);
    }

    public function show(VatRate $vat_rate)
    {
        return view('support.billing.vat_rate.show', @compact('vat_rate'));
    }

    public function edit(VatRate $vat_rate)
    {
        return view('support.billing.vat_rate.edit', @compact('vat_rate'));
    }

    public function update(UpdateVatRateRequest $request, VatRate $vat_rate)
    {
        $vat_rate = $this->repository->updateFromRequest($request, $vat_rate);

        return $this->redirectWhen($vat_rate->exists, $vat_rate->routes->show);
    }

    public function destroy(VatRate $vat_rate)
    {
        $deleted = $this->repository->delete($vat_rate);

        return $this->redirectWhen($deleted, $vat_rate->routes->index);
    }
}
