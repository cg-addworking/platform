<?php

namespace Components\Contract\Contract\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\MissionRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ContractAjaxController extends Controller
{
    private $enterpriseRepository;
    private $contractModelRepository;
    private $userRepository;
    private $missionRepository;

    public function __construct(
        EnterpriseRepository $enterpriseRepository,
        ContractModelRepository $contractModelRepository,
        UserRepository $userRepository,
        MissionRepository $missionRepository
    ) {
        $this->enterpriseRepository = $enterpriseRepository;
        $this->contractModelRepository = $contractModelRepository;
        $this->userRepository = $userRepository;
        $this->missionRepository = $missionRepository;
    }

    public function getSignatories(Request $request)
    {
        $request->validate([
           'enterprise_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $enterprise = Enterprise::where('id', $request->input('enterprise_id'))->first();
            $signatories = $this->enterpriseRepository->getSignatoriesOf($enterprise);
            $response = [
                'status' => 200,
                'data' => $signatories->sortBy('name')->pluck('name', 'id'),
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function getPartners(Request $request)
    {
        $request->validate([
           'enterprise_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $enterprise = Enterprise::where('id', $request->input('enterprise_id'))->first();
            if ($enterprise->is(Enterprise::where('name', "ADDWORKING")->first())) {
                $partners =  Enterprise::orderBy('name', 'asc')->get();
            } else {
                $ancestors = App::make(FamilyEnterpriseRepository::class)->getAncestors($enterprise, true);
                $vendors = new Collection;
                foreach ($ancestors as $customer) {
                    foreach ($customer->vendors as $vendor) {
                        $vendors->push($vendor);
                    }
                }
                $partners = $ancestors->merge($vendors->unique());
            }
            $response = [
                'status' => 200,
                'data' => $partners->sortBy('name')->pluck('name', 'id'),
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function getVendors(Request $request)
    {
        $request->validate([
            'enterprise_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $vendors = new Collection;

            $auth_user = $this->userRepository->connectedUser();
            $addworking = Enterprise::where('name', 'ADDWORKING')->first();
            if ($addworking->getId() === $request->input('enterprise_id') &&
                $this->userRepository->isSupport($auth_user)) {
                $enterprise = $this->enterpriseRepository->getAllEnterprises()->add($addworking);
            } else {
                $enterprise = Enterprise::where('id', $request->input('enterprise_id'))->first();
                $vendors->push($this->enterpriseRepository->getVendorsOf($enterprise));
            }
            $vendors->push($enterprise);

            $response = [
                'status' => 200,
                'data' => $vendors->flatten()->unique('id')->sortBy('name')->pluck('name', 'id'),
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function getContractModels(Request $request)
    {
        $request->validate([
            'enterprise_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $enterprise = Enterprise::where('id', $request->input('enterprise_id'))->first();
            $contract_models = $this->enterpriseRepository
                ->getPublishedContractModels($enterprise)
                ->pluck('display_name', 'id');

            $response = [
                'status' => 200,
                'data' => $contract_models,
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function getAmendmentOwnerEnterprise(Request $request)
    {
        $request->validate([
            'contract_model_id' => 'nullable|uuid|exists:addworking_contract_contract_models,id'
        ]);

        if ($request->ajax()) {
            $auth_user = $this->userRepository->connectedUser();
            $addworking = Enterprise::where('name', 'ADDWORKING')->first();

            $contract_model = is_null($request->input('contract_model_id'))
                ? null
                : $this->contractModelRepository->find($request->input('contract_model_id'));

            if (!is_null($contract_model)) {
                $enterprises = $this->contractModelRepository->getEnterpriseAndChildren($contract_model);
            } else {
                $enterprises = ($this->userRepository->isSupport($auth_user)
                    ? Enterprise::get()
                    : $this->userRepository->getEnterprisesOf($auth_user));
            }
            $enterprises->push($addworking);
            $enterprises = $enterprises->sortBy('name')->pluck('name', 'id');

            $response = [
                'status' => 200,
                'data' => $enterprises,
            ];

            return response()->json($response);
        }

        abort(501);
    }

    public function getEnterprises(Request $request)
    {
        if ($request->ajax()) {
            $auth_user = $this->userRepository->connectedUser();

            if ($this->userRepository->isSupport($auth_user)) {
                $contract_model = $request->filled('contract_model_id') ?
                    $this->contractModelRepository->find($request->input('contract_model_id')) : null;

                $enterprises = ! is_null($contract_model) ?
                    $this->contractModelRepository->getEnterpriseAndChildren($contract_model)
                        ->sortBy('name')
                        ->pluck('name', 'id') : [];
            } else {
                $enterprises = $this->enterpriseRepository->getUserEnterprises($auth_user)->pluck('name', 'id');
            }

            $response = [
                'status' => 200,
                'data' => $enterprises,
            ];

            return response()->json($response);
        }
        abort(501);
    }

    public function getEnterpriseMissions(Request $request)
    {
        $request->validate([
            'enterprise_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $enterprise = $this->enterpriseRepository->find($request->input('enterprise_id'));

            $missions = $this->missionRepository->getMissionsFor($enterprise)
                ->pluck('label', 'id');

            return response()->json([
                'status' => 200,
                'data' => $missions,
            ]);
        }

        abort(501);
    }

    public function getCustomerVendors(Request $request)
    {
        $request->validate([
            'enterprise_id' => 'required|uuid|exists:addworking_enterprise_enterprises,id'
        ]);

        if ($request->ajax()) {
            $enterprise = $this->enterpriseRepository->find($request->input('enterprise_id'));

            $vendors = $this->enterpriseRepository->getVendorsOf($enterprise)
                ->pluck('name', 'id');


            return response()->json([
                'status' => 200,
                'data' => $vendors,
            ]);
        }

        abort(501);
    }

    public function getContractOwnerEnterprises(Request $request)
    {
        $enterprises = [];
        $user = Auth::user();

        if ($request->ajax()) {
            if ($this->userRepository->isSupport($user)) {
                $enterprises = Enterprise::select('id', 'name')->orderBy('name', 'ASC')->get()->pluck('name', 'id');
            } else {
                $enterprises = $user->enterprises->sortBy('name')->pluck('name', 'id');
            }

            return response()->json([
                'status' => 200,
                'data' => $enterprises,
            ]);
        }

        abort(501);
    }

    public function getContractParties(Request $request)
    {
        $enterprises = [];
        $user = Auth::user();

        if ($request->ajax()) {
            if ($this->userRepository->isSupport($user)) {
                $enterprises = Enterprise::select('id', 'name')->orderBy('name', 'ASC')->get()->pluck('name', 'id');
            } else {
                $enterprises = App::make(EnterpriseRepository::class)->getPartners($user);
            }

            return response()->json([
                'status' => 200,
                'data' => $enterprises,
            ]);
        }

        abort(501);
    }

    public function getContractCreatorUsers(Request $request)
    {
        $users = [];
        $user = Auth::user();

        if ($request->ajax()) {
            if ($this->userRepository->isSupport($user)) {
                $users = $this->userRepository->getAllUsersHasAccessToContract()->sortBy('name')->pluck('name', 'id');
            } else {
                $users = $this->userRepository->getUsersOfEnterprisesOf($user)->sortBy('name')->pluck('name', 'id');
            }

            return response()->json([
                'status' => 200,
                'data' => $users,
            ]);
        }

        abort(501);
    }

    public function getListOfContractModels(Request $request)
    {
        $contract_models = [];
        $user = Auth::user();

        if ($request->ajax()) {
            if ($this->userRepository->isSupport($user)) {
                $contract_models = $this->contractModelRepository->getAllPublishedContractModels()
                    ->sortBy('display_name')->pluck('display_name_with_owner', 'id');
            } else {
                $contract_models = $this->enterpriseRepository->getPublishedContractModels($user->enterprise)
                    ->get()->sortBy('display_name')->pluck('display_name_with_owner', 'id');
            }

            return response()->json([
                'status' => 200,
                'data' => $contract_models,
            ]);
        }

        abort(501);
    }

    public function getWorkfields(Request $request)
    {
        $work_fields = [];
        $user = Auth::user();

        if ($request->ajax()) {
            if ($this->userRepository->isSupport($user)) {
                $work_fields = App::make(ContractRepository::class)->getWorkFieldsAttachedToContract()
                    ->flatten()->unique('id')->sortBy('display_name')->pluck('display_name', 'id');
            } else {
                $work_fields = $this->userRepository->getWorkFieldsWhichUserIsMember($user)
                    ->sortBy('display_name')->pluck('display_name', 'id');
            }

            return response()->json([
                'status' => 200,
                'data' => $work_fields,
            ]);
        }

        abort(501);
    }
}
