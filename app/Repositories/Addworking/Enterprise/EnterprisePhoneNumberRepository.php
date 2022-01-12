<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;

class EnterprisePhoneNumberRepository implements RepositoryInterface
{
    public function getPrimaryPhoneNumber(Enterprise $enterprise): string
    {
        return optional($enterprise->phoneNumbers()->first())->number ?? '';
    }

    public function getSecondaryPhoneNumber(Enterprise $enterprise): string
    {
        return optional($enterprise->phoneNumbers()->take(2)->get()->get(1))->number ?? '';
    }

    public function getPhoneNumber(Enterprise $enterprise): PhoneNumber
    {
        return $enterprise->phoneNumbers()->firstOrNew([]);
    }
}
