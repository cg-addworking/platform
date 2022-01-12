<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseCollection;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Illuminate\Support\Collection;

class CustomerRepository implements RepositoryInterface
{
    protected $familyEnterpriseRepository;

    public function __construct(FamilyEnterpriseRepository $familyEnterpriseRepository)
    {
        $this->familyEnterpriseRepository = $familyEnterpriseRepository;
    }

    public static function getAvailableCustomers(): Collection
    {
        return Enterprise::where('is_customer', true)
            ->where('name', '!=', '')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function isCustomer(Enterprise $enterprise): bool
    {
        return $enterprise->is_customer;
    }

    public function isCustomerOf(Enterprise $customer, Enterprise $vendor): bool
    {
        return $customer->vendors()->where('id', $vendor->id)->exists();
    }

    public function hasCustomers(Enterprise $enterprise): bool
    {
        return $enterprise->customers()->exists();
    }

    public function getActiveCustomersAndAncestorsOf(Enterprise $enterprise, $active = true)
    {
        $active_customers = new Collection;
        $inactive_customers = new Collection;

        foreach ($enterprise->customers as $customer) {
            if ($enterprise->vendorInActivityWithCustomer($customer)) {
                $active_customers->push($this->familyEnterpriseRepository->getAncestors($customer, true));
            } else {
                $inactive_customers->push($this->familyEnterpriseRepository->getAncestors($customer, true));
            }
        }

        if ($active) {
            return $active_customers->flatten();
        }

        return $inactive_customers->flatten();
    }

    public function getCustomersAndAncestorsOf(Enterprise $vendor)
    {
        $customers = new Collection;

        foreach ($vendor->customers as $customer) {
            $customers->push($this->familyEnterpriseRepository->getAncestors($customer, true));
        }

        return $customers->flatten();
    }
}
