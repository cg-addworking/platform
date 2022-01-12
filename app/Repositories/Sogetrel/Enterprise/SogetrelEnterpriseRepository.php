<?php

namespace App\Repositories\Sogetrel\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;

class SogetrelEnterpriseRepository implements RepositoryInterface
{
    public function getSogetrelEnterprise(): Enterprise
    {
        $query = Enterprise::withTrashed()->where('name', "SOGETREL");

        return $query->firstOrFail();
    }

    // ------------------------------------------------------------------------
    // Sogetrel Group
    // ------------------------------------------------------------------------

    public function isSogetrel(Enterprise $enterprise): bool
    {
        return $enterprise->name == 'SOGETREL';
    }

    public function isSubsidiaryOfSogetrel(Enterprise $enterprise): bool
    {
        return $this->isSogetrel($enterprise)
            || $enterprise->parent->exists && $this->isSubsidiaryOfSogetrel($enterprise->parent);
    }

    public function isMemberOfSogetrelGroup(Enterprise $enterprise): bool
    {
        if (! Enterprise::whereName('SOGETREL')->exists()) {
            return false;
        }

        return $enterprise->isMemberOfFamily(Enterprise::fromName('SOGETREL'));
    }

    // ------------------------------------------------------------------------
    // Vendors
    // ------------------------------------------------------------------------

    public function isVendorOfSogetrel(Enterprise $enterprise): bool
    {
        return $enterprise->customers()->whereName('SOGETREL')->exists();
    }

    public function isVendorOfSogetrelSubsidiaries(Enterprise $vendor): bool
    {
        if (! Enterprise::whereName('SOGETREL')->exists()) {
            return false;
        }

        $enterprises = Enterprise::fromName('SOGETREL')->descendants()->pluck('id');
        return $vendor->customers()->whereIn('customer_id', $enterprises)->exists();
    }

    // ------------------------------------------------------------------------
    // Sogetrel Domain
    // ------------------------------------------------------------------------
    public function isPartOfSogetrelDomain(Enterprise $enterprise): bool
    {
        if (! Enterprise::whereName('SOGETREL')->exists()) {
            return false;
        }

        return $enterprise->isPartOfDomain(Enterprise::fromName('SOGETREL'));
    }
}
