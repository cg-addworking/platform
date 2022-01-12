<?php

namespace App\Http\Controllers\Everial\Mission;

use App\Models\Everial\Mission\Price;
use App\Models\Everial\Mission\Referential;
use App\Repositories\Everial\Mission\PriceRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PriceController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(PriceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, Referential $referential)
    {
        $this->authorize('index', Price::class);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($referential, $request) {
            $query->whereHas('referential', function ($query) use ($referential) {
                $query->where('id', $referential->id);
            })->when($request->user()->enterprise->isVendor(), function ($query) use ($request) {
                $query->whereHas('vendor', function ($query) use ($request) {
                    $query->where('id', $request->user()->enterprise->id);
                });
            });
        });

        return view('everial.mission.price.index', @compact('items', 'referential'));
    }
}
