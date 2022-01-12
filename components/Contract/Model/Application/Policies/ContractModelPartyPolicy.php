<?php

namespace Components\Contract\Model\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Components\Contract\Model\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContractModelPartyPolicy
{
    use HandlesAuthorization;

    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $userRepository;

    public function __construct(
        ContractModelPartyRepository $contractModelPartyRepository,
        ContractModelRepository $contractModelRepository,
        UserRepository $userRepository
    ) {
        $this->contractModelPartyRepository = $contractModelPartyRepository;
        $this->contractModelRepository      = $contractModelRepository;
        $this->userRepository               = $userRepository;
    }

    public function delete(User $user, ContractModelParty $contract_model_party, ContractModel $contract_model)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (! $this->contractModelPartyRepository->isDeletable($contract_model_party)) {
            return Response::deny("Contract model party can't be deleted");
        }

        return Response::allow();
    }
}
