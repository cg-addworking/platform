<?php

namespace Components\Contract\Contract\Application\Repositories;

use Carbon\Carbon;
use Components\Contract\Contract\Application\Models\ContractNotification;
use Components\Contract\Contract\Domain\Exceptions\ContractNotificationCreationFailedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractNotificationEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractNotificationRepositoryInterface;

class ContractNotificationRepository implements ContractNotificationRepositoryInterface
{
    public function make($data = []): ContractNotificationEntityInterface
    {
        return new ContractNotification($data);
    }

    public function save(ContractNotificationEntityInterface $contract_notification)
    {
        try {
            $contract_notification->save();
        } catch (ContractNotificationCreationFailedException $exception) {
            throw $exception;
        }

        $contract_notification->refresh();

        return $contract_notification;
    }

    public function findNotification(
        ContractEntityInterface $contract,
        $sent_to,
        $notification_name
    ): ?ContractNotification {
        return ContractNotification::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->whereHas('sentTo', function ($q) use ($sent_to) {
            $q->where('id', $sent_to->id);
        })->where('notification_name', $notification_name)
        ->first();
    }

    public function notificationExists(
        ContractEntityInterface $contract,
        array $notification_name_exists,
        array $notification_name_doesnt_exist
    ): bool {
        return ContractNotification::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->whereIn('notification_name', $notification_name_exists)
        ->whereNotIn('notification_name', $notification_name_doesnt_exist)
        ->count() >= 1;
    }

    public function createRequestDocumentNotification(ContractEntityInterface $contract, $user)
    {
        return $this->createNotification($contract, $user, ContractNotification::REQUEST_DOCUMENTS);
    }

    public function createRequestContractVariableValueNotification(ContractEntityInterface $contract, $user)
    {
        return $this->createNotification(
            $contract,
            $user,
            ContractNotification::REQUEST_CONTRACT_VARIABLE_VALUE
        );
    }

    public function createRequestSignatureNotification(ContractEntityInterface $contract, $user)
    {
        return $this->createNotification($contract, $user, ContractNotification::REQUEST_SIGNATURE);
    }

    public function createRequestSendToSignatureNotification(ContractEntityInterface $contract, $user)
    {
        return $this->createNotification($contract, $user, ContractNotification::REQUEST_SEND_CONTRACT_TO_SIGNATURE);
    }

    public function createSignedContractNotification(ContractEntityInterface $contract, $user)
    {
        return $this->createNotification($contract, $user, ContractNotification::SIGNED_CONTRACT);
    }

    public function createRefusedContractNotification(ContractEntityInterface $contract, $user)
    {
        return $this->createNotification($contract, $user, ContractNotification::REFUSED_CONTRACT);
    }

    private function createNotification(ContractEntityInterface $contract, $user, $notification_name)
    {
        $contract_notification = $this->make();
        $contract_notification->setNotificationName($notification_name);
        $contract_notification->setContract($contract);
        $contract_notification->setSentTo($user);
        $contract_notification->setSentDate(Carbon::now());
        return $this->save($contract_notification);
    }

    public function exists(ContractEntityInterface $contract, $user, $notification_name, \DateTime $since = null): bool
    {
        $q = ContractNotification::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->whereHas('sentTo', function ($q) use ($user) {
            $q->where('id', $user->id);
        })->where('notification_name', $notification_name);

        if (!is_null($since)) {
            $q->where('created_at', '>', $since);
        }

        return $q->count() !== 0;
    }

    public function createContractNeedsVariablesValuesNotification(
        ContractEntityInterface $contract,
        $user
    ): ContractNotificationEntityInterface {
        return $this->createNotification(
            $contract,
            $user,
            ContractNotificationEntityInterface::CONTRACT_NEEDS_VARIABLES_VALUES
        );
    }
}
