<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    public function connectedUser(): User;
    public function isSupport(User $user): bool;
    public function make(): User;
    public function find(string $id): ?User;
    public function findByNumber(int $number): ?User;
    public function getUsersAllowedToSendContractToSignature(ContractEntityInterface $contract): Collection;
    public function checkIfUserHasAccessTo(User $user, ContractEntityInterface $contract): bool;
    public function getAllUsersHasAccessToContract();
    public function getUsersOfEnterprisesOf(User $user);
    public function getWorkFieldsWhichUserIsMember(User $user);
    public function checkIfUserCanChangeContractPartySignatory(User $user, Contract $contract): bool;
    public function checkIfUserCanEditSystemVariableInitialValue(User $user, Contract $contract): bool;
    public function getVendorComplianceManagerOf(Enterprise $enterprise, ContractParty $contract_party): ?Collection;
    public function checkIfUserIsMember(User $user, Enterprise $enterprise): bool;
}
