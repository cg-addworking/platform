<?php

namespace Components\Contract\Model\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContractModelPolicy
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
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function create(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function show(User $user, ContractModel $contract_model)
    {
        return $this->index($user);
    }

    public function edit(User $user, ContractModel $contract_model)
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

    public function delete(User $user, ContractModel $contract_model)
    {
        return $this->edit($user, $contract_model);
    }

    public function publish(User $user, ContractModel $contract_model)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if ($this->contractModelRepository->isPublished($contract_model)) {
            return Response::deny("Published contract model can not be published again");
        }

        if ($this->contractModelRepository->isArchived($contract_model)) {
            return Response::deny("Archived contract model can not be published");
        }

        if ($contract_model->getParties()->count() < 2) {
            return Response::deny("contract model needs to have at least 2 parties");
        }

        if ($contract_model->getParts()->count() < 1) {
            return Response::deny("contract model needs to have at least 1 part");
        }

        return Response::allow();
    }

    public function duplicate(User $user, ContractModel $contract_model)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if ($this->contractModelRepository->isDraft($contract_model)) {
            return Response::deny("Draft contract model can not be duplicate");
        }

        return Response::allow();
    }

    public function unpublish(User $user, ContractModel $contract_model)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (! $this->contractModelRepository->isPublished($contract_model)) {
            return Response::deny("the contract model is not yet published");
        }

        if ($this->contractModelRepository->isArchived($contract_model)) {
            return Response::deny('Archived contract model can not be unpublished');
        }

        if ($this->contractModelRepository->checkIfModelAttachedToContract($contract_model)) {
            return Response::deny("the contract model is attached to a contract ");
        }

        return Response::allow();
    }

    public function versionate(User $user, ContractModel $contract_model)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if ($this->contractModelRepository->isDraft($contract_model)) {
            return Response::deny("Draft contract model can not be versionate");
        }

        if ($this->contractModelRepository->isArchived($contract_model)) {
            return Response::deny("Archived contract model can not be versionate");
        }

        if (! $this->contractModelRepository->hasChildVersion($contract_model)) {
            return Response::deny("You can publish more than one contract model");
        }

        return Response::allow();
    }

    public function archive(User $user, ContractModel $contract_model)
    {
        if ($this->contractModelRepository->isDraft($contract_model)) {
            return Response::deny("Draft contract model can not be archived");
        }

        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if ($this->contractModelRepository->isArchived($contract_model)) {
            return Response::deny("Archived contract model can not be archived again");
        }

        return Response::allow();
    }
}
