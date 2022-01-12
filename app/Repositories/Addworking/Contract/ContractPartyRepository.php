<?php

namespace App\Repositories\Addworking\Contract;

use App\Contracts\Models\Repository;
use App\Http\Requests\Addworking\Contract\ContractParty\StoreContractPartyRequest;
use App\Http\Requests\Addworking\Contract\ContractParty\UpdateContractPartyRequest;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseCollection;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class ContractPartyRepository extends BaseRepository
{
    protected $model = ContractParty::class;
    protected $repositories = [];

    public function __construct(FamilyEnterpriseRepository $family)
    {
        $this->repositories['family'] = $family;
    }

    public function updateFromRequest(UpdateContractPartyRequest $request, ContractParty $contract_party): ContractParty
    {
        return $this->update($contract_party, $request->input('contract_party', []));
    }

    public function getAvailableSubsidiaries(ContractParty $contract_party): EnterpriseCollection
    {
        return $this->repositories['family']
            ->getDescendants($contract_party->contract->enterprise, true)
            ->sortBy('name');
    }

    public function getAvailableVendors(ContractParty $contract_party): EnterpriseCollection
    {
        return $this->getAvailableSubsidiaries($contract_party)
            ->vendors()
            ->sortBy('name');
    }

    public function getAvailableCustomers(ContractParty $contract_party): EnterpriseCollection
    {
        return $contract_party->contract->enterprise
            ->customers
            ->sortBy('name');
    }

    public function getAvailableSignatories(ContractParty $contract_party): Collection
    {
        $enterprise = $contract_party->enterprise;

        return $enterprise->users->filter(function ($user) use ($enterprise) {
            return $user->isSignatoryFor($enterprise)
                && $user->hasAccessToContractFor($enterprise);
        });
    }

    public function getContractDocuments(ContractParty $contract_party): Collection
    {
        return $contract_party->contract
            ->contractDocuments()
            ->whereHas('contractParty', fn($q) => $q->whereId($contract_party->id))
            ->get();
    }

    public function getCounterparts(Enterprise $enterprise): Collection
    {
        $enterprises = new Collection;

        $contracts = Contract::ofEnterprise($enterprise)
            ->exceptAddendums()
            ->with(['contractParties', 'contractParties.enterprise'])
            ->cursor();

        foreach ($contracts as $contract) {
            foreach ($contract->contractParties as $party) {
                if (! $enterprises->contains($party->enterprise)) {
                    $enterprises->push($party->enterprise);
                }
            }
        }

        return $enterprises->sortBy('name');
    }
}
