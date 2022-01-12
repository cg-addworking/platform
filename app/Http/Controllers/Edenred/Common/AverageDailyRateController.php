<?php

namespace App\Http\Controllers\Edenred\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Edenred\Common\AverageDailyRate\StoreAverageDailyRateRequest;
use App\Http\Requests\Edenred\Common\AverageDailyRate\UpdateAverageDailyRateRequest;
use App\Models\Edenred\Common\AverageDailyRate;
use App\Models\Edenred\Common\Code;
use App\Repositories\Edenred\Common\AverageDailyRateRepository;
use Illuminate\Http\Request;

class AverageDailyRateController extends Controller
{
    protected $repository;

    public function __construct(AverageDailyRateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Code $code)
    {
        $this->authorize('index', AverageDailyRate::class);

        $items = $this->repository->list()->ofCode($code)->latest()->paginate(25);

        return view('edenred.common.average_daily_rate.index', @compact('code', 'items'));
    }

    public function create(Code $code)
    {
        $this->authorize('create', AverageDailyRate::class);

        $average_daily_rate = $this->repository->make();
        $average_daily_rate->code()->associate($code);

        return view('edenred.common.average_daily_rate.create', @compact('code', 'average_daily_rate'));
    }

    public function store(StoreAverageDailyRateRequest $request, Code $code)
    {
        $average_daily_rate = $this->repository->createFromRequest($request, $code);

        return redirect_when(
            $average_daily_rate->exists,
            route('edenred.common.code.average_daily_rate.show', [$code, $average_daily_rate])
        );
    }

    public function show(Code $code, AverageDailyRate $average_daily_rate)
    {
        $this->authorize('view', $average_daily_rate);

        return view('edenred.common.average_daily_rate.show', @compact('code', 'average_daily_rate'));
    }

    public function edit(Code $code, AverageDailyRate $average_daily_rate)
    {
        $this->authorize('update', $average_daily_rate);

        return view('edenred.common.average_daily_rate.edit', @compact('code', 'average_daily_rate'));
    }

    public function update(UpdateAverageDailyRateRequest $request, Code $code, AverageDailyRate $average_daily_rate)
    {
        $average_daily_rate = $this->repository->updateFromRequest($request, $code, $average_daily_rate);

        return redirect_when(
            $average_daily_rate->exists,
            route('edenred.common.code.average_daily_rate.show', [$code, $average_daily_rate])
        );
    }

    public function destroy(Code $code, AverageDailyRate $average_daily_rate)
    {
        $this->authorize('delete', $average_daily_rate);

        $deleted = $this->repository->delete($average_daily_rate);

        return redirect_when($deleted, route('edenred.common.code.average_daily_rate.index', $code));
    }
}
