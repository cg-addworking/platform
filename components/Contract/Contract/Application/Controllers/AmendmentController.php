<?php

namespace Components\Contract\Contract\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Contract\Application\Jobs\CreateContractVariableJob;
use Components\Contract\Contract\Application\Jobs\GenerateContractPartsJob;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Application\Requests\StoreAmendmentRequest;
use Components\Contract\Contract\Application\Requests\StoreAmendmentWithoutModelRequest;
use Components\Contract\Contract\Application\Requests\StoreAmendmentWithoutModelToSignRequest;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\UseCases\AssociateMissionToContract;
use Components\Contract\Contract\Domain\UseCases\CreateAmendment;
use Components\Contract\Contract\Domain\UseCases\CreateAmendmentWithoutModelToSign;
use Components\Contract\Contract\Domain\UseCases\CreateSignedAmendmentWithoutModel;
use Components\Contract\Contract\Domain\UseCases\IdentifyValidator;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class AmendmentController extends Controller
{
    private $contractRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $contractModelRepository;

    public function __construct(
        ContractRepository $contractRepository,
        EnterpriseRepository $enterpriseRepository,
        UserRepository $userRepository,
        ContractModelRepository $contractModelRepository
    ) {
        $this->contractRepository = $contractRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository = $userRepository;
        $this->contractModelRepository = $contractModelRepository;
    }

    public function create(Request $request, Contract $contract_parent)
    {
        $this->authorize('createAmendment', $contract_parent);

        if (auth()->user()->isSupport()) {
            $enterprises_with_model = Enterprise::has('publishedContractModels')
                ->orderBy('name')
                ->cursor();
        } else {
            $enterprises_with_model = Enterprise::has('publishedContractModels')
                ->whereIn('id', auth()->user()->enterprises->pluck('id'))
                ->orderBy('name')
                ->cursor();
        }


        $enterprise = Enterprise::find($request->input('enterprise')) ?? $enterprises_with_model->first();

        $contract_models = is_null($enterprise)
            ? []
            : $this->enterpriseRepository->getPublishedContractModels($enterprise)->pluck('display_name', 'id');

        $contract_model = $request->has('contract_model') && !is_null($request->get('contract_model')) ?
            $this->contractModelRepository->find($request->input('contract_model')) : null;

        $enterprises = !is_null($contract_model) ?
            $this->contractModelRepository->getEnterpriseAndChildren($contract_model)
            : new Collection([]);
        $enterprises->push($contract_parent->getEnterprise());
        $enterprises = $enterprises->sortBy('name')->pluck('name', 'id');

        $work_field = $this->contractRepository->getWorkfieldOf($contract_parent);

        $selectable_validators = [];
        if (! is_null($work_field)) {
            $selected_workField_contributor_validators = App::make(WorkFieldContributorRepository::class)
                ->getWorkfieldContributorContractValidators($work_field);

            foreach ($selected_workField_contributor_validators as $item) {
                $selectable_validators[] = [
                    'id' => $item->contributor_id,
                    'order' => $item->contract_validation_order,
                ];
            }
        }

        $available_validators = $contract_parent->getEnterprise() ? $contract_parent->getEnterprise()->users : null;

        return view(
            'contract::contract.create',
            compact(
                'enterprise',
                'enterprises_with_model',
                'contract_models',
                'enterprises',
                'contract_parent',
                'selectable_validators',
                'available_validators'
            )
        );
    }

    public function store(StoreAmendmentRequest $request, Contract $contract_parent)
    {
        $this->authorize('createAmendment', $contract_parent);

        $contract = App::make(CreateAmendment::class)
            ->handle($request->user(), $contract_parent, $request->input(), $request->file('contract_part.file'));

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
            App::make(AssociateMissionToContract::class)
                ->handle($request->user(), $contract, $request->input('contract'));
        }

        if (! $this->contractRepository->getSignatoryParties($contract)->isEmpty()) {
            $contract->setState(ContractEntityInterface::STATE_GENERATING);
            $this->contractRepository->save($contract);

            Log::warning("Create Contract AMDT {$contract->getId()} start jobs (MU:".memory_get_usage().")");
            $bus = Bus::chain([
                new CreateContractVariableJob($contract),
                new GenerateContractPartsJob($request->user(), $contract),
            ])->catch(function (\Throwable $e) use ($contract) {
                Log::error("Create Contract AMDT {$contract->getId()} failed jobs");
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

            Log::warning("Create Contract AMDT {$contract->getId()} finish jobs (MU:".memory_get_usage().")");

            return $this->redirectWhen($contract->exists, route('contract.show', $contract));
        }

        return $this->redirectWhen($contract->exists, route('contract.party.create', $contract));
    }

    public function createAmendmentWithoutModelToSign(Contract $contract_parent)
    {
        $this->authorize('createAmendmentWithoutModelToSign', $contract_parent);

        $work_field = $this->contractRepository->getWorkfieldOf($contract_parent);

        $selectable_validators = [];
        if (! is_null($work_field)) {
            $selected_workField_contributor_validators = App::make(WorkFieldContributorRepository::class)
                ->getWorkfieldContributorContractValidators($work_field);

            foreach ($selected_workField_contributor_validators as $item) {
                $selectable_validators[] = [
                    'id' => $item->contributor_id,
                    'order' => $item->contract_validation_order,
                ];
            }
        }

        $available_validators = $contract_parent->getEnterprise() ? $contract_parent->getEnterprise()->users : null;

        $contract = $this->contractRepository->make();

        return view(
            'contract::contract.amendment.create_without_model_to_sign',
            compact(
                'contract',
                'contract_parent',
                'selectable_validators',
                'available_validators'
            )
        );
    }

    public function storeAmendmentWithoutModelToSign(
        StoreAmendmentWithoutModelToSignRequest $request,
        Contract $contract_parent
    ) {
        $this->authorize('storeAmendmentWithoutModelToSign', $contract_parent);

        $contract = App::make(CreateAmendmentWithoutModelToSign::class)->handle(
            $this->userRepository->connectedUser(),
            $request->input(),
            $request->file('contract_part.file'),
            $contract_parent
        );

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

        return $this->redirectWhen($contract->exists, route('contract.show', $contract));
    }

    public function createAmendmentWithoutModel(Contract $contract_parent)
    {
        $this->authorize('createAmendmentWithoutModel', $contract_parent);

        $contract = $this->contractRepository->make();

        return view(
            'contract::contract.amendment.create_without_model',
            compact(
                'contract',
                'contract_parent',
            )
        );
    }

    public function storeAmendmentWithoutModel(StoreAmendmentWithoutModelRequest $request, Contract $contract_parent)
    {
        $this->authorize('storeAmendmentWithoutModel', $contract_parent);

        $contract = App::make(CreateSignedAmendmentWithoutModel::class)->handle(
            $this->userRepository->connectedUser(),
            $request->input(),
            $request->file('contract_part.file'),
            $contract_parent
        );

        return $this->redirectWhen($contract->exists, route('contract.show', $contract));
    }
}
