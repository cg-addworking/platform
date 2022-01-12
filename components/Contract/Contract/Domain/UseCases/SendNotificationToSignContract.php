<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Domain\Exceptions\ContractDoesHavePartiesException;
use Components\Contract\Contract\Domain\Exceptions\ContractInvalidStateException;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\ContractPartyBelongsToAnotherContract;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractNotificationRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;

class SendNotificationToSignContract
{
    protected $userRepository;
    protected $contractRepository;
    protected $contractNotificationRepository;
    protected $contractPartyRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ContractRepositoryInterface $contractRepository,
        ContractNotificationRepositoryInterface $contractNotificationRepository,
        ContractPartyRepositoryInterface $contractPartyRepository
    ) {
        $this->userRepository = $userRepository;
        $this->contractRepository = $contractRepository;
        $this->contractNotificationRepository = $contractNotificationRepository;
        $this->contractPartyRepository = $contractPartyRepository;
    }

    public function handle(
        ?User $auth_user,
        Contract $contract,
        ContractPartyEntityInterface $party_to_notify,
        $is_followup = true
    ) {
        $this->checkContract($contract);
        $this->checkParty($contract, $party_to_notify);

        if (!is_null($party_to_notify->getSignatory())) {
            $sended = $this->contractRepository->sendNotificationToSignContract(
                $contract,
                $party_to_notify,
                $is_followup
            );

            if ($sended) {
                $this->contractNotificationRepository
                    ->createRequestSignatureNotification(
                        $contract,
                        $party_to_notify->getSignatory()
                    );
            }

            return true;
        }

        return false;
    }

    public function checkParty(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $party_to_notify
    ) {
        if ($party_to_notify->getContract()->getId() !== $contract->getId()) {
            throw new ContractPartyBelongsToAnotherContract;
        }
    }

    private function checkContract($contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException();
        }

        if (! $contract->parties()->count()) {
            throw new ContractDoesHavePartiesException();
        }

        if ($contract->getState() !== ContractEntityInterface::STATE_TO_SIGN) {
            throw new ContractInvalidStateException;
        }
    }
}
