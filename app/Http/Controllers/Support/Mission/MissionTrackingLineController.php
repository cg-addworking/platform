<?php

namespace App\Http\Controllers\Support\Mission;

use App\Builders\Addworking\Mission\TrackingLineCsvBuilder;
use App\Http\Controllers\Controller;
use App\Repositories\Addworking\Mission\MissionTrackingLineRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;

class MissionTrackingLineController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(MissionTrackingLineRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $items = $this->getPaginatorFromRequest($request);

        return view('support.mission.index', @compact('items'));
    }

    public function export(Request $request, TrackingLineCsvBuilder $builder)
    {
        $items = $this->repository->list($request->input('search'), $request->input('filter'))->cursor();

        return $builder->addAll($items)->download();
    }
}
