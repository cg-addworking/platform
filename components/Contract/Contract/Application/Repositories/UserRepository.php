<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Enterprise\WorkField\Application\Models\WorkField;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function connectedUser(): User
    {
        return Auth::user();
    }

    public function isSupport(User $user): bool
    {
        return $user->isSupport();
    }

    public function make(): User
    {
        return new User;
    }

    public function find(string $id): ?User
    {
        return User::where('id', $id)->first();
    }

    public function findByNumber(int $number, ?bool $trashed = null): ?User
    {
        if ($trashed) {
            return User::withwhere('number', $number)->first();
        }

        return User::where('number', $number)->first();
    }

    public function getEnterprisesOf(User $user)
    {
        return $user->enterprises()->get();
    }

    public function getUsersAllowedToSendContractToSignature(ContractEntityInterface $contract): Collection
    {
        $contract_enterprise = $contract->getEnterprise();
        $allowed_users = new Collection();
        foreach ($contract_enterprise->users()->get() as $user) {
            if ($user->hasRoleFor($contract_enterprise, User::ROLE_SEND_CONTRACT_TO_SIGNATURE)) {
                $allowed_users->add($user);
            }
        }
        return $allowed_users;
    }

    public function checkIfUserHasAccessTo(User $user, ContractEntityInterface $contract): bool
    {
        return $user->enterprises()->get()->contains($contract->getEnterprise());
    }

    public function getAllUsersHasAccessToContract()
    {
        return User::whereHas('enterprises', function ($query) {
            return $query->where(User::ROLE_CONTRACT_CREATOR, true);
        })->get();
    }

    public function getUsersOfEnterprisesOf(User $user)
    {
        return User::whereHas('enterprises', function ($query) use ($user) {
            $query->whereIn('id', $user->enterprises()->pluck('id'));
        })->get();
    }

    public function getWorkFieldsWhichUserIsMember(User $user)
    {
        return WorkField::whereHas('owner', function ($query) use ($user) {
            $query->where('id', $user->enterprise->id);
        })->get();
    }

    public function checkIfUserCanChangeContractPartySignatory(User $user, Contract $contract): bool
    {
        return $user->enterprises()->get()->contains($contract->getEnterprise())
            && ! is_null($contract->getCreatedBy())
            && $user->is($contract->getCreatedBy())
            && in_array($contract->getState(), [
                ContractEntityInterface::STATE_IN_PREPARATION,
                ContractEntityInterface::STATE_MISSING_DOCUMENTS,
                ContractEntityInterface::STATE_GENERATED
            ]);
    }

    public function checkIfUserCanEditSystemVariableInitialValue(User $user, Contract $contract): bool
    {
        return $user->can('edit', $contract);
    }

    public function getVendorComplianceManagerOf(Enterprise $enterprise, ContractParty $contract_party): ?Collection
    {
        return $enterprise->users()
            ->wherePivot(User::IS_VENDOR_COMPLIANCE_MANAGER, true)->get()
            ->filter(function ($item) use ($contract_party) {
                return ! $item->is($contract_party->getSignatory());
            });
    }

    /**
     * @param User $user
     * @param Enterprise $enterprise
     * @return bool
     */
    public function checkIfUserIsMember(User $user, Enterprise $enterprise): bool
    {
        return $enterprise->users()->get()->contains($user);
    }
}
