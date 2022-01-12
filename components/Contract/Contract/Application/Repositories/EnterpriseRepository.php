<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function findBySiret(string $siret): ?Enterprise
    {
        return Enterprise::where('identification_number', $siret)->first();
    }

    public function make(): Enterprise
    {
        return new Enterprise();
    }

    public function find(string $id): ?Enterprise
    {
        return Enterprise::where('id', $id)->first();
    }

    public function hasAccessToContractModel(Enterprise $enterprise, ContractModelEntityInterface $contract_model): bool
    {
        $family = App::make(FamilyEnterpriseRepository::class)->getFamily($enterprise);

        return $family->contains($contract_model->getEnterprise());
    }

    public function getPublishedContractModels(Enterprise $enterprise)
    {
        $ancestors = App::make(FamilyEnterpriseRepository::class)->getAncestors($enterprise, true);

        return ContractModel::whereNotNull('published_at')->whereNull('archived_at')
        ->whereHas('enterprise', function ($query) use ($ancestors) {
            $query->whereIn('enterprise_id', $ancestors->pluck('id'));
        });
    }

    public function getPartners(User $user)
    {
        $partners = new Collection;

        $addworking = Enterprise::where('name', 'ADDWORKING')->first();

        $enterprises = Enterprise::with('vendors', 'customers')->whereHas('users', function ($query) use ($user) {
            return $query->where('id', $user->id);
        })->get();

        foreach ($enterprises as $enterprise) {
            $partners->push($addworking);
            $partners->push($enterprise->customers()->get());
            $partners->push($enterprise->vendors()->get());
        }

        return $partners->flatten()->unique('id')->sortBy('name')->pluck('name', 'id');
    }

    public function getAllEnterprises()
    {
        return Enterprise::all();
    }

    public function hasPartnershipWithContract(Enterprise $party_enterprise, ContractEntityInterface $contract): bool
    {
        return Arr::exists($this->getEnterprisesWithContractPartnership($contract), $party_enterprise->id);
    }

    public function getEnterprisesWithContractPartnership(ContractEntityInterface $contract)
    {
        $addworking_ids = Enterprise::whereIn('name', ['ADDWORKING', 'ADDWORKING DEUTSCHLAND GMBH'])
            ->pluck('id')->toArray();

        if (in_array($contract->getEnterprise()->id, $addworking_ids)) {
            return Enterprise::orderBy('name', 'asc')->pluck('name', 'id');
        }

        $ancestors = App::make(FamilyEnterpriseRepository::class)->getAncestors($contract->getEnterprise(), true);
        $vendors = new Collection;

        foreach ($ancestors as $customer) {
            foreach ($customer->vendors as $vendor) {
                $vendors->push($vendor);
            }
        }

        return $ancestors->merge($vendors->unique())->pluck('name', 'id');
    }

    public function getSignatoriesOf(Enterprise $enterprise)
    {
        return $enterprise->signatories()->get();
    }

    public function getAncestors(Enterprise $enterprise, bool $include_self = false): Collection
    {
        $ancestors = $enterprise->parent->exists
            ? $this->getAncestors($enterprise->parent)->push($enterprise->parent)
            : $enterprise->newCollection();

        if ($include_self) {
            $ancestors->push($enterprise);
        }

        return $ancestors;
    }

    public function getDescendants(Enterprise $enterprise, bool $include_self = false): Collection
    {
        $descendants = $enterprise->children->reduce(
            fn($carry, $child) => $carry->push($child)->merge($this->getDescendants($child)),
            $enterprise->newCollection()
        );

        if ($include_self) {
            $descendants->push($enterprise);
        }

        return $descendants;
    }

    public function getEterprisesAscendentWhereHasContractModels(User $user)
    {
        $user_enterprises = $user->enterprises()->get();
        $enterprises = new Collection();
        foreach ($user_enterprises as $user_enterprise) {
            $ancestors = App::make(FamilyEnterpriseRepository::class)->getAncestors($user_enterprise, true);
            $enterprises->push($ancestors);
        }

        $enterprises = $enterprises->flatten()->unique('id');

        return $enterprises->reject(function ($enterprise) {
            return $enterprise->publishedContractModels()->get()->isEmpty();
        });
    }

    public function getEterpriseOwnerWithVendors(ContractEntityInterface $contract)
    {
        $enterprises = new Collection;
        $enterprises->push($contract->getEnterprise());
        $enterprises->push($contract->getEnterprise()->vendors->sortBy('name'));

        return $enterprises->flatten();
    }

    public function getUserEnterprises(User $user)
    {
        return $user->enterprises()->get();
    }

    public function getVendorsOf(Enterprise $customer)
    {
        return $customer->vendors()->get();
    }
    public function hasContractModels(Enterprise $enterprise): bool
    {
        return $this->getPublishedContractModels($enterprise)->count() > 0;
    }
}
