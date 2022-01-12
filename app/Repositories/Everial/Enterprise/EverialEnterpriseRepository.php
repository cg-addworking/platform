<?php

namespace App\Repositories\Everial\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;

class EverialEnterpriseRepository implements RepositoryInterface
{
    public function isEverial(Enterprise $enterprise): bool
    {
        return $enterprise->name == 'EVERIAL';
    }

    public function isPartOfEverialDomain(Enterprise $enterprise): bool
    {
        if (! Enterprise::whereName('SPF - SOCIETE DE PARTICIPATIONS FINANCIERES')->exists()) {
            return false;
        }

        return $enterprise->isPartOfDomain(Enterprise::fromName('SPF - SOCIETE DE PARTICIPATIONS FINANCIERES'));
    }
}
