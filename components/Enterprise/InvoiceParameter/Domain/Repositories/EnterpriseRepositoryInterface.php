<?php
namespace Components\Enterprise\InvoiceParameter\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseEntityInterface;

interface EnterpriseRepositoryInterface
{
    public function find($id): ?EnterpriseEntityInterface;
    public function findBySiret(string $siret): ?EnterpriseEntityInterface;
    public function findEnterpriseByName(string $enterprise_name): ?Enterprise;
}
