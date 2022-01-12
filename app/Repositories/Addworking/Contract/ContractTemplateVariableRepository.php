<?php

namespace App\Repositories\Addworking\Contract;

use App\Contracts\Models\Repository;
use App\Http\Requests\Addworking\Contract\ContractTemplateVariable\StoreContractTemplateVariableRequest;
use App\Http\Requests\Addworking\Contract\ContractTemplateVariable\UpdateContractTemplateVariableRequest;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractTemplateVariable;
use App\Repositories\BaseRepository;

class ContractTemplateVariableRepository extends BaseRepository
{
    protected $model = ContractTemplateVariable::class;

    public function createFromRequest(
        StoreContractTemplateVariableRequest $request,
        ContractTemplate $template
    ): ContractTemplateVariable {
        return tap($this->make($request->input('contract_template_variable', [])), function ($var) use ($template) {
            $var->contractTemplate()->associate($template)->save();
        });
    }

    public function updateFromRequest(
        UpdateContractTemplateVariableRequest $request,
        ContractTemplateVariable $contract_template_variable
    ): ContractTemplateVariable {
        return $this->update($contract_template_variable, $request->input('contract_template_variable', []));
    }
}
