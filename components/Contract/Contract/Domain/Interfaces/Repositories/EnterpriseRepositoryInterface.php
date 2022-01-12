<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Illuminate\Database\Eloquent\Collection;

interface EnterpriseRepositoryInterface
{
    public function findBySiret(string $siret): ?Enterprise;
    public function make(): Enterprise;
    public function find(string $id): ?Enterprise;
    public function hasAccessToContractModel(
        Enterprise $enterprise,
        ContractModelEntityInterface $contract_model
    ): bool;
    public function getPublishedContractModels(Enterprise $enterprise);
    public function getPartners(User $user);
    public function getAllEnterprises();
    public function hasPartnershipWithContract(Enterprise $enterprise, ContractEntityInterface $contract): bool;
    public function getEnterprisesWithContractPartnership(ContractEntityInterface $contract);
    public function getSignatoriesOf(Enterprise $enterprise);
    public function getAncestors(Enterprise $enterprise, bool $include_self = false): Collection;
    public function getEterprisesAscendentWhereHasContractModels(User $user);
    public function getEterpriseOwnerWithVendors(ContractEntityInterface $contract);
    public function getUserEnterprises(User $user);
    public function getVendorsOf(Enterprise $customer);
    public function hasContractModels(Enterprise $enterprise): bool;
}
