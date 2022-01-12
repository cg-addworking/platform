<?php

namespace Components\Contract\Model\Application\Repositories;

use Components\Contract\Model\Application\Models\ContractModelVariable;
use Components\Contract\Model\Domain\Exceptions\ContractModelVariableCreationFailedException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelVariableEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelVariableRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class ContractModelVariableRepository implements ContractModelVariableRepositoryInterface
{
    public function make($data = []): ContractModelVariableEntityInterface
    {
        return new ContractModelVariable($data);
    }

    public function save(ContractModelVariableEntityInterface $contract_model_variable)
    {
        try {
            $contract_model_variable->save();
        } catch (ContractModelVariableCreationFailedException $exception) {
            throw $exception;
        }

        $contract_model_variable->refresh();

        return $contract_model_variable;
    }

    public function list(ContractModelEntityInterface $contract_model, ?array $filter = null, ?string $search = null)
    {
        $paginated_variables = ContractModelVariable::query()
            ->whereHas('contractModel', function ($query) use ($contract_model) {
                $query->where('id', $contract_model->getId());
            })
            ->with(['contractModelPart'])
            ->orderBy('order', 'asc')
            ->paginate(42000);

        $variables = $paginated_variables->sortBy('order');

        return new LengthAwarePaginator($variables, $paginated_variables->total(), $paginated_variables->perPage());
    }

    public function findVariables(string $content): array
    {
        $pattern = "#\{\{\s*(.*?)\s*\}\}#";

        $variables = [];
        if (preg_match_all($pattern, $content, $matches)) {
            foreach ($matches[1] as $variable) {
                if (!in_array($variable, $variables)) {
                    $variables[] = $variable;
                }
            }
        }

        return $variables;
    }

    public function deleteVariables(ContractModelPartEntityInterface $contract_model_part): bool
    {
        $variables = $contract_model_part->getVariables();
        $count = $variables->count();

        return ContractModelVariable::destroy($variables->pluck('id')) == $count;
    }

    public function deleteVariable(ContractModelVariable $contract_model_variable)
    {
        $contract_model_variable->delete();
    }

    public function getVariableDisplayName(string $content):string
    {
        $names = explode("_", $content);
        $name = implode(" ", $names);
        
        return ucfirst($name);
    }

    public function variableExists(
        ContractModelPartyEntityInterface $party,
        ContractModelPartEntityInterface $part,
        string $name
    ) {
        return ContractModelVariable::whereHas('contractModelParty', function ($q) use ($party) {
            $q->where('id', $party->getId());
        })->whereHas('contractModelPart', function ($q) use ($part) {
            $q->where('id', $part->getId());
        })->where('name', $name)
        ->count() >= 1;
    }

    public function setVariables(Collection $variables, ContractModelPartEntityInterface $contract_model_part)
    {
        foreach ($variables as $i => $variable) {
            $this->setVariable($variable, $contract_model_part, $i);
        }
    }

    public function setVariable(
        string $variable,
        ContractModelPartEntityInterface $contract_model_part,
        int $order
    ) {
        $variable = explode('.', $variable);
        $party_order = $variable[0];
        $name = str_slug($variable[1], '_');

        $contract_model_party = App::make(ContractModelPartyRepository::class)->findByOrder(
            $contract_model_part->getContractModel(),
            $party_order
        );

        if ($this->variableExists($contract_model_party, $contract_model_part, $name)) {
            return;
        }

        $contract_model_variable = $this->make();
        $contract_model_variable->setContractModel($contract_model_part->getContractModel());
        $contract_model_variable->setContractModelParty($contract_model_party);
        $contract_model_variable->setName($name);
        $contract_model_variable->setNumber();
        $name_variable = $this->getVariableDisplayName($name);
        $contract_model_variable->setDisplayName($name_variable);

        $contract_model_variable->setContractModelPart($contract_model_part);
        $contract_model_variable->setOrder($order);
        $contract_model_variable = $this->save($contract_model_variable);
    }

    public function findByNumber(int $number): ?ContractModelVariableEntityInterface
    {
        return ContractModelVariable::where('number', $number)->first();
    }

    public function find(string $id): ContractModelVariableEntityInterface
    {
        return ContractModelVariable::where('id', $id)->first();
    }

    public function getAvailableInputTypes(bool $trans = false): array
    {
        $translation_base = "components.contract.model.application.models.contract_model_variable.input_type";

        $input_types =  [
            __("{$translation_base}.text_title") => [
                ContractModelVariable::INPUT_TYPE_TEXT =>
                    __("{$translation_base}.text"),
                ContractModelVariable::INPUT_TYPE_LONG_TEXT =>
                    __("{$translation_base}.long_text"),
                ContractModelVariable::INPUT_TYPE_DATE =>
                    __("{$translation_base}.date"),
                ContractModelVariable::INPUT_TYPE_OPTIONS =>
                    __("{$translation_base}.options"),
            ],
            __("{$translation_base}.enterprise_title") => [
                ContractModelVariable::INPUT_TYPE_ENTERPRISE_LEGAL_FORM =>
                    __("{$translation_base}.enterprise_legal_form"),
                ContractModelVariable::INPUT_TYPE_ENTERPRISE_NAME =>
                    __("{$translation_base}.enterprise_name"),
                ContractModelVariable::INPUT_TYPE_ENTERPRISE_ADDRESS =>
                    __("{$translation_base}.enterprise_address"),
                ContractModelVariable::INPUT_TYPE_ENTERPRISE_TOWN =>
                    __("{$translation_base}.enterprise_town"),
                ContractModelVariable::INPUT_TYPE_ENTERPRISE_IDENTIFICATION_NUMBER =>
                    __("{$translation_base}.enterprise_identification_number"),
                ContractModelVariable::INPUT_TYPE_ENTERPRISE_SIREN_NUMBER =>
                __("{$translation_base}.enterprise_siren_number"),
                ContractModelVariable::INPUT_TYPE_ENTERPRISE_REGISTRATION_TOWN =>
                    __("{$translation_base}.registration_town"),
                ContractModelVariable::INPUT_TYPE_ENTERPRISE_REGISTRATION_DATE =>
                    __("{$translation_base}.enterprise_registration_date"),
                ContractModelVariable::INPUT_TYPE_ENTERPRISE_EMPLOYEES_NUMBER =>
                    __("{$translation_base}.enterprise_employees_number"),
            ],
            __("{$translation_base}.signatory_title") => [
                ContractModelVariable::INPUT_TYPE_SIGNATORY_NAME =>
                    __("{$translation_base}.signatory_name"),
                ContractModelVariable::INPUT_TYPE_SIGNATORY_MAIL =>
                __("{$translation_base}.signatory_mail"),
                ContractModelVariable::INPUT_TYPE_SIGNATORY_FUNCTION =>
                __("{$translation_base}.signatory_function"),
            ],
            __("{$translation_base}.contract_title") => [
                ContractModelVariable::INPUT_TYPE_CONTRACT_ENTERPRISE_OWNER =>
                    __("{$translation_base}.contract_enterprise_owner"),
                ContractModelVariable::INPUT_TYPE_CONTRACT_VALID_FROM =>
                    __("{$translation_base}.contract_valid_from"),
                ContractModelVariable::INPUT_TYPE_CONTRACT_VALID_UNTIL =>
                    __("{$translation_base}.contract_valid_until"),
                ContractModelVariable::INPUT_TYPE_CONTRACT_EXTERNAL_IDENTIFIER =>
                    __("{$translation_base}.contract_external_identifier"),
            ],
            __("{$translation_base}.mission_title") => [
                ContractModelVariable::INPUT_TYPE_STARTED_AT =>
                    __("{$translation_base}.mission_started_at"),
                ContractModelVariable::INPUT_TYPE_ENDED_AT =>
                    __("{$translation_base}.mission_ended_at"),
                ContractModelVariable::INPUT_TYPE_MISSION_AMOUNT =>
                __("{$translation_base}.mission_amount"),
            ],
            __("{$translation_base}.work_field_title") => [
                ContractModelVariable::INPUT_TYPE_WORK_FIELD_DISPLAY_NAME =>
                    __("{$translation_base}.work_field_display_name"),
                ContractModelVariable::INPUT_TYPE_WORK_FIELD_EXTERNAL_ID =>
                    __("{$translation_base}.work_field_external_id"),
                ContractModelVariable::INPUT_TYPE_WORK_FIELD_STARTED_AT =>
                    __("{$translation_base}.work_field_started_at"),
                ContractModelVariable::INPUT_TYPE_WORK_FIELD_ENDED_AT =>
                    __("{$translation_base}.work_field_ended_at"),
                ContractModelVariable::INPUT_TYPE_WORK_FIELD_DESCRIPTION =>
                    __("{$translation_base}.work_field_description"),
                ContractModelVariable::INPUT_TYPE_WORK_FIELD_PROJECT_OWNER =>
                    __("{$translation_base}.work_field_project_owner"),
                ContractModelVariable::INPUT_TYPE_WORK_FIELD_PROJECT_MANAGER =>
                    __("{$translation_base}.work_field_project_manager"),
                ContractModelVariable::INPUT_TYPE_WORK_FIELD_ADDRESS =>
                    __("{$translation_base}.work_field_address"),
                ContractModelVariable::INPUT_TYPE_WORK_FIELD_SPS_COORDINATOR =>
                __("{$translation_base}.work_field_sps_coordinator"),
            ],
        ];

        return $trans ? $input_types : array_keys($input_types);
    }

    public function refreshVariables(ContractModelPartEntityInterface $contract_model_part, $new_variables)
    {
        $old_variables = $contract_model_part
            ->getVariables()
            ->mapWithKeys(function ($variable) {
                return [$variable->getId() => $variable->getContractModelParty()->getOrder().'.'.$variable->getName()];
            });

        foreach ($old_variables as $id => $old_variable) {
            if (!in_array($old_variable, $new_variables)) {
                $old_value = $this->find($id);
                $this->deleteVariable($old_value);
            }
        }

        $order = 1;
        foreach ($new_variables as $key => $new_variable) {
            if (in_array($new_variable, $old_variables->toArray())) {
                $id = array_search($new_variable, $old_variables->toArray());
                $old_value = $this->find($id);
                $old_value->setOrder($order);
                $this->save($old_value);
            } else {
                $this->setVariable($new_variable, $contract_model_part, $order);
            }

            $order++;
        }
    }
}
