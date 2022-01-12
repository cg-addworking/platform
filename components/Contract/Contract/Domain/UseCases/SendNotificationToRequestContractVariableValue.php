<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\CommentRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractNotificationRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class SendNotificationToRequestContractVariableValue
{
    protected $userRepository;
    protected $contractRepository;
    protected $contractNotificationRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ContractRepositoryInterface $contractRepository,
        ContractNotificationRepositoryInterface $contractNotificationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->contractRepository = $contractRepository;
        $this->contractNotificationRepository = $contractNotificationRepository;
    }

    public function handle(User $auth_user, ContractEntityInterface $contract, string $url, User $user_to_request)
    {
        $this->checkUser($auth_user);
        $this->checkContract($contract);

        $this->handleSendNotification($contract, $auth_user, $user_to_request, $url);

        return true;
    }

    private function handleSendNotification($contract, $auth_user, $user_to_request, $url)
    {
        $this->contractRepository->sendNotificationRequestContractVariableValue(
            $contract,
            $user_to_request,
            $url
        );

        $this->contractNotificationRepository->createRequestContractVariableValueNotification(
            $contract,
            $user_to_request
        );

        ActionTrackingHelper::track(
            $user_to_request,
            ActionEntityInterface::CONTRACT_VARIABLE_VALUE_WAS_REQUESTED,
            $contract,
            __(
                'components.contract.contract.application.tracking.contract_variable_value_was_requested',
                [
                    'user_to_request_name' => $user_to_request->name,
                ]
            )
        );
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }

        if (!$this->userRepository->isSupport($user)) {
            throw new UserIsNotSupportException();
        }
    }

    private function checkContract($contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException();
        }
    }
}
