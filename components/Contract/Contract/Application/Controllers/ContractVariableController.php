<?php

namespace Components\Contract\Contract\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Contract\Application\Jobs\GenerateContractPartsForSogetrelJob;
use Components\Contract\Contract\Application\Jobs\GenerateContractPartsJob;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Contract\Application\Models\ContractVariable;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\UseCases\ListContractVariable;
use Components\Contract\Model\Application\Repositories\ContractModelVariableRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ContractVariableController extends Controller
{
    private $contractVariableRepository;
    private $contractRepository;
    private $contractModelVariableRepository;
    private $contractPartyRepository;
    private $userRepository;

    public function __construct(
        ContractRepository $contractRepository,
        ContractVariableRepository $contractVariableRepository,
        ContractModelVariableRepository $contractModelVariableRepository,
        ContractPartyRepository $contractPartyRepository,
        UserRepository $userRepository
    ) {
        $this->contractVariableRepository = $contractVariableRepository;
        $this->contractRepository = $contractRepository;
        $this->contractModelVariableRepository = $contractModelVariableRepository;
        $this->contractPartyRepository = $contractPartyRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request, Contract $contract)
    {
        $this->authorize('index', [ContractVariable::class, $contract]);
        $items = App::make(ListContractVariable::class)->handle(
            $this->userRepository->connectedUser(),
            $contract,
            $request->input('filter'),
            $request->input('search'),
            $request->input('per-page')
        );

        $input_types = $this->contractModelVariableRepository->getAvailableInputTypes(true);

        return view('contract::contract_variable.index', compact('items', 'contract', 'input_types'));
    }

    public function edit(Request $request, Contract $contract)
    {
        $this->authorize('edit', [ContractVariable::class, $contract]);

        $user = $this->userRepository->connectedUser();

        $contract_parts = ContractPart::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->orderBy('order', 'asc')->get();

        $variables_by_parts = [];
        foreach ($contract_parts as $part) {
            $contract_variables = $this->contractVariableRepository
                ->getUserFillableContractVariable(
                    $contract,
                    $user,
                    $part
                );

            if (count($contract_variables)) {
                $variables_by_parts[$part->getId()] = $contract_variables;
            }
        }

        $contract_users = $this->contractPartyRepository->getPartyOwnerUsers($contract);

        $requested_contract_variables = explode(',', $request->input('requested-contract-variables'));

        return view(
            'contract::contract_variable.define_value',
            compact(
                'contract',
                'variables_by_parts',
                'user',
                'contract_users',
                'requested_contract_variables',
            )
        );
    }

    public function update(Request $request, Contract $contract)
    {
        $this->authorize('edit', [ContractVariable::class, $contract]);

        $request->validate([
            'variable_value' => 'nullable|string',
            'variable_id' => 'required|uuid|exists:addworking_contract_contract_variables,id',
        ]);

        if ($request->ajax()) {
            $variable_id = $request->input('variable_id');
            $contract_variable = ContractVariable::find($variable_id);
            $contract_variable->setValue($request->input('variable_value'));
            $contract_variable->setFilledBy($request->user());
            $this->contractVariableRepository->save($contract_variable);
            $this->contractVariableRepository->updateObjectValuesFromSystemVariables(
                $contract_variable,
                $request->user()
            );

            $response = ['status' => 200];

            return response()->json($response);
        }

        abort(501);
    }

    public function refreshSystemVariables(Contract $contract)
    {
        $this->authorize('edit', [ContractVariable::class, $contract]);

        if ($this->contractRepository->canBeRegenerated($contract)) {
            $this->contractVariableRepository->updateSystemContractVariables($contract);
            $contract->setState(ContractEntityInterface::STATUS_GENERATING);
            $this->contractRepository->save($contract);

            // todo: temporary solution to isolate generation of sogetrel contracts
            $sogetrel = Enterprise::where('name', 'SOGETREL')->first();
            $sogetrelFamily = App::make(EnterpriseRepository::class)->getDescendants($sogetrel, true);

            if ($sogetrelFamily->contains($contract->getEnterprise())) {
                GenerateContractPartsForSogetrelJob::dispatch($this->userRepository->connectedUser(), $contract);
            } else {
                GenerateContractPartsJob::dispatchSync($this->userRepository->connectedUser(), $contract);
            }
        }

        return redirect()->back();
    }
}
