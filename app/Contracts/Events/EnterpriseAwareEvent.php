<?php

namespace App\Contracts\Events;

use App\Models\Addworking\Enterprise\Enterprise;

interface EnterpriseAwareEvent
{
    public function getEnterprise(): Enterprise;

    public function setEnterprise(Enterprise $enterprise);
}
