<?php

namespace App\Http\Controllers\Addworking\User;

use App\Http\Controllers\Controller;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Repositories\Addworking\User\UserRepository;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\User\User\Application\Repositories\DashboardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $enterpriseRepository;
    protected $userRepository;
    protected $contractRepository;
    protected $dashboardRepository;

    public function __construct(
        EnterpriseRepository $enterprise_repository,
        UserRepository $user_repository,
        ContractRepository $contract_repository,
        DashboardRepository $dashboardRepository
    ) {
        $this->enterpriseRepository = $enterprise_repository;
        $this->userRepository = $user_repository;
        $this->contractRepository = $contract_repository;
        $this->dashboardRepository = $dashboardRepository;
    }

    /**
     * Show the application dashboard.
     *
     */
    public function index(Request $request)
    {
        if ($request->user()->is(User::julienPerona())) {
            abort(403);
        }

        if (app()->environment('demo')) {
            $auth_user = Auth::user();

            $data = [
                'auth_user_firstname' => $this->dashboardRepository->getAuthUserFirstName(),
                'auth_user_id' => $auth_user->id,
                'auth_user_enterprise' => $auth_user->enterprise,
                'number_of_contract_to_sign' => $this->dashboardRepository->getNumberOfContractToSign($auth_user->id),
                'contracts_to_sign' => $this->dashboardRepository->getContractsToSign($auth_user->id),
                'number_of_contract_pending' => $this->dashboardRepository->getNumberOfContractPending($auth_user->id),
                'contracts_pending' => $this->dashboardRepository->getContractsPending($auth_user->id),
            ];
        } else {
            $user = $request->user();
            $enterprise = $user->enterprise;

            $data = [
                'vendors_count'                 => $this->enterpriseRepository->getVendorsCount($enterprise),
                'missions_count'                => $this->enterpriseRepository->getMissionsCount($enterprise),
                'vendor_invoices_count'         => $this->enterpriseRepository->getVendorInvoicesCount($enterprise),
                'customer_invoices_count'       => $this->enterpriseRepository->getCustomerInvoicesCount($enterprise),
                'unread_responses_count'        => $this->enterpriseRepository->getUnreadResponsesCount($enterprise),
                'contracts_count'               => $this->contractRepository->countContractsOfState($user),
                'active_contracts_count'        => $this->contractRepository->countContractsOfState(
                    $user,
                    Contract::STATE_ACTIVE
                ),
                'missions_of_this_month_count' => $this->enterpriseRepository->getMissionsOfThisMonthCount($enterprise),
                'offers_to_validate_count'      => $this->enterpriseRepository->getOffersToValidateCount($enterprise),
                'proposals_count'               => $this->enterpriseRepository->getProposalsCount($enterprise),
            ];
        }

        return view('addworking.user.dashboard.index', ['data' => $data]);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show()
    {
        abort(501);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        abort(501);
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit()
    {
        abort(501);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store()
    {
        abort(501);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update()
    {
        abort(501);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy()
    {
        abort(501);
    }
}
