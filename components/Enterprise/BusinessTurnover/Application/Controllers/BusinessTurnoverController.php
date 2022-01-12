<?php

namespace Components\Enterprise\BusinessTurnover\Application\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Components\Enterprise\BusinessTurnover\Application\Models\BusinessTurnover;
use Components\Enterprise\BusinessTurnover\Application\Repositories\BusinessTurnoverRepository;
use Components\Enterprise\BusinessTurnover\Application\Repositories\UserRepository;
use Components\Enterprise\BusinessTurnover\Application\Requests\StoreBusinessTurnoverRequest;
use Components\Enterprise\BusinessTurnover\Domain\UseCases\CreateBusinessTurnover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BusinessTurnoverController extends Controller
{
    protected $businessTurnoverRepository;
    protected $userRepository;

    public function __construct(
        BusinessTurnoverRepository $businessTurnoverRepository,
        UserRepository $userRepository
    ) {
        $this->businessTurnoverRepository = $businessTurnoverRepository;
        $this->userRepository = $userRepository;
    }

    public function create(Request $request)
    {
        $this->authorize('create', BusinessTurnover::class);

        $business_turnover = $this->businessTurnoverRepository->make();

        $year = Carbon::now()->subYear()->year;

        return view('business_turnover::business_turnover.create', compact('business_turnover', 'year'));
    }

    public function store(StoreBusinessTurnoverRequest $request)
    {
        $this->authorize('create', BusinessTurnover::class);

        $authenticated = $this->userRepository->connectedUser();

        $business_turnover = App::make(CreateBusinessTurnover::class)->handle(
            $authenticated,
            $authenticated->enterprise,
            $request->input('business_turnover')
        );

        if (Session::has('business_turnover_callback_url')) {
            return Redirect::to(Session::get('business_turnover_callback_url'));
        }

        return $this->redirectWhen($business_turnover->exists, route('enterprise.show', $request->user()->enterprise));
    }

    public function skip(Request $request)
    {
        $this->authorize('skip', BusinessTurnover::class);

        if (Config::get('business_turnover.skippable')) {
            Session::put('business_turnover_skipped', true);

            return Redirect::to(Session::get('business_turnover_callback_url'));
        }

        abort(404);
    }
}
