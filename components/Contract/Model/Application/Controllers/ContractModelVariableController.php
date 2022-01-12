<?php

namespace Components\Contract\Model\Application\Controllers;

use App\Http\Controllers\Controller;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelVariable;
use Components\Contract\Model\Application\Repositories\ContractModelVariableRepository;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Components\Contract\Model\Application\Requests\UpdateContractModelVariableRequest;
use Components\Contract\Model\Domain\UseCases\EditContractModelVariable;
use Components\Contract\Model\Domain\UseCases\ListContractModelVariable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ContractModelVariableController extends Controller
{
    private $contractModelVariableRepository;
    private $userRepository;

    public function __construct(
        ContractModelVariableRepository $contractModelVariableRepository,
        UserRepository $userRepository
    ) {
        $this->contractModelVariableRepository = $contractModelVariableRepository;
        $this->userRepository = $userRepository;
    }

    public function index(ContractModel $contract_model)
    {
        $this->authorize('index', ContractModelVariable::class);

        $items = App::make(ListContractModelVariable::class)->handle(
            $this->userRepository->connectedUser(),
            $contract_model
        );

        return view('contract_model::contract_model_variable.index', compact('items', 'contract_model'));
    }

    public function edit(ContractModel $contract_model)
    {
        $this->authorize('edit', [ContractModelVariable::class, $contract_model]);

        $items = App::make(ListContractModelVariable::class)->handle(
            $this->userRepository->connectedUser(),
            $contract_model
        );

        $input_types = $this->contractModelVariableRepository->getAvailableInputTypes(true);

        return view('contract_model::contract_model_variable.edit', compact('items', 'contract_model', 'input_types'));
    }

    public function update(ContractModel $contract_model, UpdateContractModelVariableRequest $request)
    {
        $this->authorize('edit', [ContractModelVariable::class, $contract_model]);

        DB::transaction(function () use ($request) {
            foreach ($request->input('contract_model_variable') as $inputs) {
                App::make(EditContractModelVariable::class)->handle(
                    $this->userRepository->connectedUser(),
                    $inputs,
                );
            }
        });

        return redirect(route('support.contract.model.variable.index', $contract_model));
    }
}
