<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces;

use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseCollection;
use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Common\Common\Domain\Interfaces\RepositoryInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseEntityInterface;

interface EnterpriseRepositoryInterface extends RepositoryInterface
{
    public function find(string $uuid): EnterpriseEntityInterface;

    /**
     * @todo return type should be EnterpriseEntityInterface
     */
    public function findBySiret(string $siret);

    public function findByIds(array $ids): EnterpriseCollection;

    public function make($data = []): EnterpriseEntityInterface;

    /**
     * @todo relocate on EnterpriseEntity::isVendors
     */
    public function isVendor(Enterprise $enterprise): bool;

    public function save(EntityInterface $entity): bool;

    public function list(
        ?array $filter = null,
        ?string $search = null,
        ?string $page,
        ?string $operator = null,
        ?string $field_name = null
    );
    
    public function getSearchableAttributes(): array;

    public function checkPartnership(Enterprise $customer, Enterprise $vendor): bool;

    public function checkPartnershipActivity(Enterprise $customer, Enterprise $vendor): bool;

    public function isCompliantFor(Enterprise $vendor, Enterprise $customer): bool;
}
