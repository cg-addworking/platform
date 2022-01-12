<?php
namespace Components\Enterprise\InvoiceParameter\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseEntityInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\EnterpriseRepositoryInterface;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function find($id): ?EnterpriseEntityInterface
    {
        return Enterprise::where('id', $id)->first();
    }

    public function findBySiret(string $siret): ?EnterpriseEntityInterface
    {
        return Enterprise::where('identification_number', $siret)->first();
    }

    /**
     * @param string $enterprise_name
     * @return Enterprise|null
     */
    public function findEnterpriseByName(string $enterprise_name): ?Enterprise
    {
        return Enterprise::whereName($enterprise_name)->first();
    }
}
