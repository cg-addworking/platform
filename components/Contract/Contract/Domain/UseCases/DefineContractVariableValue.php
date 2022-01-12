<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAllowedToDefineVariableValueException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractVariableEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractStateRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractVariableRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DefineContractVariableValue
{
    use Dispatchable, SerializesModels;

    private $userRepository;
    private $contractRepository;
    private $contractVariableRepository;
    private $contractStateRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ContractRepositoryInterface $contractRepository,
        ContractVariableRepositoryInterface $contractVariableRepository,
        ContractStateRepositoryInterface $contractStateRepository
    ) {
        $this->userRepository     = $userRepository;
        $this->contractRepository = $contractRepository;
        $this->contractVariableRepository = $contractVariableRepository;
        $this->contractStateRepository = $contractStateRepository;
    }

    public function handle(?User $auth_user, $variables, $input_variables): array
    {
        $is_user_support = $this->userRepository->isSupport($auth_user);
        $this->checkUser($auth_user);
        $response = [];
        foreach ($variables as $variable) {
            if ($this->contractVariableRepository->isEditable($variable)) {
                $this->checkUserRight($auth_user, $is_user_support, $variable);
                $value = $input_variables[$variable->getId()];
                $variable = $this->setContractVariableValue($auth_user, $variable, $value);
                $response[] = $variable;
            }
            unset($variable);
        }
        return $response;
    }

    private function setContractVariableValue($auth_user, $variable, $value)
    {
        $variable->setValue($value ?? '');
        $variable->setFilledBy($auth_user);

        if ($this->contractVariableRepository->isOptions($variable) && !is_null($value)) {
            $variable->setValue($variable->getContractModelVariable()->getOptions()[$value]);
        }

        $this->contractVariableRepository->save($variable);

        return $variable;
    }

    public function checkUser(?User $auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException;
        }
    }

    public function checkUserRight(?User $auth_user, $is_user_support, $variable)
    {
        if (!$is_user_support
            && !$auth_user->enterprises->contains($variable->getContract()->getEnterprise())
        ) {
            throw new UserIsNotAllowedToDefineVariableValueException();
        }
    }
}
