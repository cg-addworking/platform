<?php

namespace Components\Contract\Contract\Application\Controllers;

use App\Http\Controllers\Controller;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\AccountingMonitoringRepository;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class AccountingMonitoringController extends Controller
{
    private $userRepository;
    private $accountingMonitoringRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AccountingMonitoringRepository $accountingMonitoringRepository
    ) {
        $this->userRepository = $userRepository;
        $this->accountingMonitoringRepository = $accountingMonitoringRepository;
    }

    public function index(Request $request)
    {
        $this->authorize('indexAccountingMonitoring', Contract::class);

        $user = $this->userRepository->connectedUser();

        $items = $this->accountingMonitoringRepository->list(
            $user,
            $request->input('search'),
            $request->input('per-page'),
            $request->input('operator'),
            $request->input('field'),
            $request->input('filter'),
        );

        $searchable_attributes = $this->accountingMonitoringRepository->getSearchableAttributes();

        return view(
            'contract::accounting_monitoring.index',
            compact('items', 'searchable_attributes')
        );
    }
}
