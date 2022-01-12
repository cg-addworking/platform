<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Exceptions\ContractPartyCreationFailedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Illuminate\Support\Facades\App;

class ContractPartyRepository implements ContractPartyRepositoryInterface
{
    public function find(string $id): ?ContractPartyEntityInterface
    {
        return ContractParty::where('id', $id)->first();
    }

    public function make($data = []): ContractPartyEntityInterface
    {
        return new ContractParty($data);
    }

    public function save(ContractPartyEntityInterface $contract_party)
    {
        try {
            $contract_party->save();
        } catch (ContractPartyCreationFailedException $exception) {
            throw $exception;
        }

        $contract_party->refresh();

        return $contract_party;
    }

    public function delete(ContractPartyEntityInterface $contract_party): bool
    {
        return $contract_party->delete();
    }

    public function isDeleted(ContractPartyEntityInterface $contract_party)
    {
        return ! is_null($contract_party->getDeletedAt());
    }

    public function findByNumber(int $number): ?ContractPartyEntityInterface
    {
        return ContractParty::where('number', $number)->first();
    }

    public function list(ContractEntityInterface $contract)
    {
        return ContractParty::query()
            ->whereHas('contract', function ($query) use ($contract) {
                return $query->where('id', $contract->getId());
            })->where('is_validator', false)
            ->orderBy('order', 'asc')
            ->get();
    }

    public function getSignatoriesWithoutOwner(ContractEntityInterface $contract)
    {
        $parties = ContractParty::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->whereHas('enterprise', function ($query) use ($contract) {
            return $query->where('id', '!=', $contract->getEnterprise()->id);
        })->orderBy('order', 'asc')->get();

        $signatories = [];

        foreach ($parties as $party) {
            $signatories[] = User::where('id', $party->getSignatory()->id)->first();
        }

        return $signatories;
    }

    public function getPartyForContract(User $user, Contract $contract): ?ContractPartyEntityInterface
    {
        return ContractParty::whereHas('contract', function ($q) use ($contract) {
            return $q->where('id', $contract->getId());
        })->whereHas('enterprise', function ($q) use ($user) {
            return $q->whereIn('id', $user->enterprises->pluck('id'));
        })->where('is_validator', false)
            ->orderBy('order', 'asc')
            ->first();
    }

    public function getNextPartyValidatorForContract(User $user, Contract $contract): ?ContractPartyEntityInterface
    {
        return ContractParty::whereHas('contract', function ($q) use ($contract) {
            return $q->where('id', $contract->getId());
        })->whereHas('enterprise', function ($q) use ($user) {
            return $q->whereIn('id', $user->enterprises->pluck('id'));
        })->where('is_validator', true)
            ->whereNull('validated_at')
            ->orderBy('order', 'asc')
            ->first();
    }

    public function calculateSignaturePosition(int $order): string
    {
        switch ($order) {
            case 1:
                $position = "32,70,130,141";
                break;
            case 2:
                $position = "172,70,270,141";
                break;
            case 3:
                $position = "302,70,410,141";
                break;
            case 4:
                $position = "432,70,560,141";
                break;
        }

        return $position;
    }

    public function getFirstSigningParty(ContractEntityInterface $contract): ?ContractPartyEntityInterface
    {
        return ContractParty::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->where('order', 1)
        ->first();
    }

    public function getNextPartyThatShouldSign(ContractEntityInterface $contract): ?ContractPartyEntityInterface
    {
        return ContractParty::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })
        ->where('is_validator', false)
        ->whereNull('signed_at')
        ->orderBy('order', 'ASC')
        ->first();
    }

    public function getNextPartyThatShouldValidate(ContractEntityInterface $contract): ?ContractPartyEntityInterface
    {
        return ContractParty::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })
        ->where('is_validator', true)
        ->whereNull('validated_at')
        ->orderBy('order', 'ASC')
        ->first();
    }

    public function isNextPartyThatShouldSign(User $user, ContractEntityInterface $contract): bool
    {
        $next_party_that_should_sign = $this->getNextPartyThatShouldSign($contract);

        if (is_null($next_party_that_should_sign)) {
            return false;
        }
        return $user->is($next_party_that_should_sign->getSignatory());
    }

    public function isNextPartyThatShouldValidate(User $user, ContractEntityInterface $contract): bool
    {
        $next_party_that_should_sign = $this->getNextPartyThatShouldValidate($contract);

        if (is_null($next_party_that_should_sign)) {
            return false;
        }
        return $user->is($next_party_that_should_sign->getSignatory());
    }

    public function getUserValidatorParty(User $user, ContractEntityInterface $contract)
    {
        return ContractParty::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->whereHas('signatory', function ($q) use ($user) {
            $q->where('id', $user->getId());
        })->where('is_validator', true)
        ->first();
    }

    public function getPartyOwnerOf(Contract $contract): ?ContractPartyEntityInterface
    {
        return ContractParty::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->whereHas('enterprise', function ($query) use ($contract) {
            return $query->where('id', '=', $contract->getEnterprise()->id);
        })
        ->where('is_validator', false)
        ->first();
    }

    public function checkIfCurrentUserCanSendTheContractToManger(User $user, Contract $contract): bool
    {
        $party = $this->getPartyOwnerOf($contract);

        if ($party) {
            $enterprise_users = $party->getEnterprise()->users;

            foreach ($enterprise_users as $enterprise_user) {
                if ($enterprise_user->id === $user->id) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getPartyOwnerUsers(ContractEntityInterface $contract)
    {
        $party_owner = $this->getPartyOwnerOf($contract);
        return $party_owner->getEnterprise()->users->pluck('name', 'id');
    }

    public function getContractPartyByOrderOf(ContractEntityInterface $contract, int $order): ?ContractParty
    {
        return App::make(ContractRepositoryInterface::class)
            ->getSignatoryParties($contract)->where('order', $order)->first();
    }
}
