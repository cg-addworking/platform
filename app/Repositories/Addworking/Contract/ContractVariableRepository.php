<?php

namespace App\Repositories\Addworking\Contract;

use App\Contracts\Models\Repository;
use App\Http\Requests\Addworking\Contract\ContractVariable\StoreContractVariableRequest;
use App\Http\Requests\Addworking\Contract\ContractVariable\UpdateContractVariableRequest;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractVariable;
use App\Repositories\BaseRepository;

class ContractVariableRepository extends BaseRepository
{
    protected $model = ContractVariable::class;

    public function createFromRequest(StoreContractVariableRequest $request, Contract $contract): ContractVariable
    {
        return tap($this->make($request->input('contract_variable', [])), function ($var) use ($request, $contract) {
            $var
                ->contract()->associate($contract)
                ->contractTemplateVariable()->associate($request->input('contract_template_variable.id'))
                ->save();
        });
    }

    public function updateFromRequest(
        UpdateContractVariableRequest $request,
        ContractVariable $contract_variable
    ): ContractVariable {
        return $this->update($contract_variable, $request->input('contract_variable', []));
    }
}
