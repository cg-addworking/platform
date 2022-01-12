<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;

interface ContractPartyRepositoryInterface
{
    public function find(string $id): ?ContractPartyEntityInterface;
    public function make($data = []): ContractPartyEntityInterface;
    public function save(ContractPartyEntityInterface $contract_party);
    public function delete(ContractPartyEntityInterface $contract_party): bool;
    public function isDeleted(ContractPartyEntityInterface $contract_party);
    public function findByNumber(int $number): ?ContractPartyEntityInterface;
    public function list(ContractEntityInterface $contract);
    public function getSignatoriesWithoutOwner(ContractEntityInterface $contract);
    public function getPartyForContract(User $user, Contract $contract): ?ContractPartyEntityInterface;
    public function getFirstSigningParty(ContractEntityInterface $contract): ?ContractPartyEntityInterface;
    public function getNextPartyThatShouldSign(ContractEntityInterface $contract): ?ContractPartyEntityInterface;
    public function isNextPartyThatShouldSign(User $user, ContractEntityInterface $contract): bool;
    public function getNextPartyThatShouldValidate(ContractEntityInterface $contract): ?ContractPartyEntityInterface;
    public function isNextPartyThatShouldValidate(User $user, ContractEntityInterface $contract): bool;
    public function getNextPartyValidatorForContract(User $user, Contract $contract): ?ContractPartyEntityInterface;
    public function getUserValidatorParty(User $user, ContractEntityInterface $contract);
    public function getPartyOwnerOf(Contract $contract): ?ContractPartyEntityInterface;
    public function checkIfCurrentUserCanSendTheContractToManger(User $user, Contract $contract): bool;
    public function getPartyOwnerUsers(ContractEntityInterface $contract);
    public function getContractPartyByOrderOf(ContractEntityInterface $contract, int $order): ?ContractParty;
}
