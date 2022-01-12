<?php

namespace Components\Contract\Model\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Exceptions\ContractModelVariableIsNotFoundException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelVariableEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelVariableRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;

class EditContractModelVariable
{
    private $contractModelVariableRepository;
    private $userRepository;

    public function __construct(
        ContractModelVariableRepositoryInterface $contractModelVariableRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->contractModelVariableRepository = $contractModelVariableRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(
        User $auth_user,
        array $inputs
    ) {
        $this->checkUser($auth_user);

        $contract_model_variable = $this->contractModelVariableRepository->find($inputs['id']);

        $this->checkContractModelVariable($contract_model_variable);

        $contract_model_variable = $this->updateContractModelVariable($contract_model_variable, $inputs);

        return $this->contractModelVariableRepository->save($contract_model_variable);
    }

    private function updateContractModelVariable(
        ContractModelVariableEntityInterface $contract_model_variable,
        array $inputs
    ): ContractModelVariableEntityInterface {
        $contract_model_variable->setDescription($inputs['description']);
        $contract_model_variable->setDefaultValue($inputs['default_value']);
        $contract_model_variable->setDisplayName($inputs['display_name']);

        $contract_model_variable->setInputType($inputs['input_type']);
        if ($inputs['input_type'] === ContractModelVariableEntityInterface::INPUT_TYPE_OPTIONS) {
            $contract_model_variable->setOptions(array_filter($inputs['options']));
            $contract_model_variable->setDefaultValue(null);
        }

        $contract_model_variable->setRequired(isset($inputs['required']));
        $contract_model_variable->setIsExportable(isset($inputs['is_exportable']));

        return $contract_model_variable;
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (! $this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException();
        }
    }

    private function checkContractModelVariable($contract_model_variable)
    {
        if (is_null($contract_model_variable)) {
            throw new ContractModelVariableIsNotFoundException();
        }
    }
}
