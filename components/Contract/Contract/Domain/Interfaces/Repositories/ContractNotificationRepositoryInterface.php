<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use Components\Contract\Contract\Application\Models\ContractNotification;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractNotificationEntityInterface;

interface ContractNotificationRepositoryInterface
{
    public function make($data = []): ContractNotificationEntityInterface;
    public function save(ContractNotificationEntityInterface $contract_notification);
    public function findNotification(
        ContractEntityInterface $contract,
        $sent_to,
        $notification_name
    ): ?ContractNotificationEntityInterface;
    public function notificationExists(
        ContractEntityInterface $contract,
        array $notification_name_exists,
        array $notification_name_doesnt_exist
    ): bool;
    public function createRequestDocumentNotification(ContractEntityInterface $contract, $user);
    public function createRequestSignatureNotification(ContractEntityInterface $contract, $user);
    public function createRequestSendToSignatureNotification(ContractEntityInterface $contract, $user);
    public function createSignedContractNotification(ContractEntityInterface $contract, $user);
    public function createRefusedContractNotification(ContractEntityInterface $contract, $user);
    public function exists(ContractEntityInterface $contract, $user, $notification_name, \DateTime $since = null): bool;
}
