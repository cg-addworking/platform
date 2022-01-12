<?php

namespace Components\Contract\Model\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelPart;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContractModelPartPolicy
{
    use HandlesAuthorization;

    private $contractModelRepository;
    private $userRepository;

    public function __construct(
        ContractModelRepository $contractModelRepository,
        UserRepository $userRepository
    ) {
        $this->contractModelRepository = $contractModelRepository;
        $this->userRepository = $userRepository;
    }

    public function index(User $user)
    {
        if (!$this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }
        return Response::allow();
    }

    public function create(User $user, ContractModel $contract_model)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if ($this->contractModelRepository->isPublished($contract_model)) {
            return Response::deny("Published contract model can not be modified");
        }

        if ($this->contractModelRepository->isArchived($contract_model)) {
            return Response::deny("Archived contract model can not be modified");
        }

        return Response::allow();
    }

    public function edit(User $user, ContractModelPart $contract_model_part)
    {
        return $this->create($user, $contract_model_part->getContractModel());
    }

    public function delete(User $user, ContractModelPart $contract_model_part)
    {
        return $this->create($user, $contract_model_part->getContractModel());
    }

    public function preview(User $user, ContractModelPart $contract_model_part)
    {
        if (!$this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }
}
