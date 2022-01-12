<?php

namespace Components\Contract\Contract\Application\Controllers;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Contract\Application\Jobs\CreateContractVariableJob;
use Components\Contract\Contract\Domain\UseCases\EditContractValidators;
use Components\Contract\Contract\Domain\UseCases\IdentifyValidator;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Domain\UseCases\IdentifyParty;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Application\Jobs\GenerateContractPartsJob;
use Components\Contract\Contract\Domain\UseCases\AssociateMissionToContract;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Requests\StoreContractPartyRequest;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Illuminate\Support\Facades\Log;

class ContractPartyController extends Controller
{
    private $enterpriseRepository;
    private $userRepository;
    private $contractRepository;
    private $contractVariableRepository;
    private $workFieldContributorRepository;

    public function __construct(
        EnterpriseRepository $enterpriseRepository,
        ContractRepository $contractRepository,
        UserRepository $userRepository,
        ContractVariableRepository $contractVariableRepository,
        WorkFieldContributorRepository $workFieldContributorRepository
    ) {
        $this->enterpriseRepository = $enterpriseRepository;
        $this->contractRepository = $contractRepository;
        $this->userRepository = $userRepository;
        $this->contractVariableRepository = $contractVariableRepository;
        $this->workFieldContributorRepository = $workFieldContributorRepository;
    }

    public function create(Contract $contract, Request $request)
    {
        $this->authorize('create', [ContractParty::class, $contract]);

        $work_field = $this->contractRepository->getWorkfieldOf($contract);

        $selectable_validators = [];
        if (! is_null($work_field)) {
            $selected_workField_contributor_validators = $this
                ->workFieldContributorRepository
                ->getWorkfieldContributorContractValidators($work_field);

            foreach ($selected_workField_contributor_validators as $item) {
                $selectable_validators[] = [
                        'id' => $item->contributor_id,
                        'order' => $item->contract_validation_order,
                ];
            }
        }

        $available_validators = $contract->getCreatedBy()->enterprise->users;

        return view(
            'contract::contract_party.create',
            compact(
                'contract',
                'available_validators',
                'selectable_validators'
            )
        );
    }

    public function store(Contract $contract, StoreContractPartyRequest $request)
    {
        $this->authorize('create', [ContractParty::class, $contract]);

        DB::transaction(function () use ($request, $contract) {
            foreach ($request->input('contract_party') as $contract_party) {
                App::make(IdentifyParty::class)->handle(
                    $request->user(),
                    $contract,
                    $contract_party
                );
            }

            if ($request->has('validators')) {
                foreach ($request->input('validators') as $order => $validator_id) {
                    App::make(IdentifyValidator::class)->handle(
                        $request->user(),
                        $contract,
                        $order,
                        $validator_id
                    );
                }
            }

            if (isset($request->input('contract')['with_mission'])) {
                App::make(AssociateMissionToContract::class)->handle(
                    $request->user(),
                    $contract,
                    $request->input('contract')
                );
            }
        });

        if ($contract->parties()->count()) {
            $contract->setState(ContractEntityInterface::STATE_GENERATING);
            $this->contractRepository->save($contract);

            Log::warning("Create Contract {$contract->getId()} start jobs (MU:".memory_get_usage().")");
            $bus = Bus::chain([
                new CreateContractVariableJob($contract),
                new GenerateContractPartsJob($request->user(), $contract),
            ])->catch(function (\Throwable $e) use ($contract) {
                Log::error("Create Contract {$contract->getId()} failed jobs");
                Log::error($e);
                throw $e;
            });

            // todo: temporary solution to isolate generation of sogetrel contracts
            $sogetrel = Enterprise::where('name', 'SOGETREL')->first();
            $sogetrelFamily = App::make(EnterpriseRepository::class)->getDescendants($sogetrel, true);

            if ($sogetrelFamily->contains($contract->getEnterprise())) {
                Log::warning("Create Contract {$contract->getId()} dispatch on sqs");
                $bus->onConnection('sqs_for_contracts')->dispatch();
            } else {
                Log::warning("Create Contract {$contract->getId()} dispatch on sync");
                $bus->onConnection('sync')->dispatch();
            }

            Log::warning("Create Contract {$contract->getId()} finish jobs (MU:".memory_get_usage().")");
        }


        return $this->redirectWhen($contract->parties()->count(), route('contract.show', $contract))
            ->with(
                success_status(
                    __('components.contract.contract.application.views.contract_party.store.success')
                )
            );
    }

    public function searchEnterprise(Request $request, Contract $contract)
    {
        $this->authorize('create', [ContractParty::class, $contract]);

        $result = [];
        $search = $request->input('name');
        $auth_user = $this->userRepository->connectedUser();
        $enterprises = [];

        if ($this->userRepository->isSupport($auth_user)) {
            $enterprises = Enterprise::orderBy('name', 'asc')
                ->where(DB::raw('LOWER(CAST(name as TEXT))'), 'LIKE', "%".strtolower($search)."%")
                ->limit(15)->get();
        } else {
            $enterprises = Enterprise::orderBy('name', 'asc')
                ->where(DB::raw('LOWER(CAST(name as TEXT))'), 'LIKE', "%".strtolower($search)."%")
                ->whereHas('customers', function ($query) use ($contract) {
                    $query->where('id', $contract->getEnterprise()->id);
                })->limit(15)->get();

            $enterprises->push($contract->getEnterprise());
        }

        foreach ($enterprises as $enterprise) {
            $result[$enterprise->id] = $enterprise->name. " (".$enterprise->identification_number.")";
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'body' => $result,
        ]);
    }

    public function getPartiesOfContract(Contract $contract, Request $request)
    {
        $auth_user = $request->user();

        if ($request->ajax()) {
            if (! is_null($contract->getMission())) {
                $mission_enterprises = $contract
                    ->getMission()->vendor()->get()
                    ->merge($contract->getMission()->customer()->get());

                $enterprises = new Collection;
                foreach ($mission_enterprises as $mission_enterprise) {
                    $enterprises = $enterprises->merge(
                        $this->enterpriseRepository->getAncestors($mission_enterprise, true)
                    );
                }
                $enterprises = $enterprises->pluck('name', 'id');
            } else {
                $enterprises = $this->userRepository->isSupport($auth_user) ?
                    $this->enterpriseRepository->getEnterprisesWithContractPartnership($contract) :
                    $this->enterpriseRepository->getEterpriseOwnerWithVendors($contract)->pluck('name', 'id');
            }

            $response = [
                'status' => 200,
                'data' => $enterprises,
            ];

            return response()->json($response);
        }

        abort(501);
    }

    /**
     * @param Contract $contract
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function editValidators(Contract $contract)
    {
        $this->authorize('editValidators', [ContractParty::class, $contract]);

        $contract_validators = $this->contractRepository->getValidatorParties($contract);

        $selectable_validators = [];
        foreach ($contract_validators as $item) {
            $selectable_validators[] = [
                'id' => $item->signatory_id,
                'order' => $item->order,
            ];
        }

        $available_validators = $contract->getCreatedBy()->enterprise->users;

        return view(
            'contract::contract.edit_validators',
            compact(
                'contract',
                'selectable_validators',
                'available_validators'
            )
        );
    }

    /**
     * @param Request $request
     * @param Contract $contract
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateValidators(Request $request, Contract $contract)
    {
        $this->authorize('editValidators', [ContractParty::class, $contract]);

        $contract = App::make(EditContractValidators::class)->handle(
            $this->userRepository->connectedUser(),
            $contract,
            $request->input('validators')
        );

        return $this->redirectWhen($contract->exists, route('contract.show', $contract));
    }
}
