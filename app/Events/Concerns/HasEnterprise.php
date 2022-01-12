<?php

namespace App\Events\Concerns;

use App\Models\Addworking\Enterprise\Enterprise;

trait HasEnterprise
{
    protected $enterprise;

    public function getEnterprise(): Enterprise
    {
        return $this->enterprise;
    }

    public function setEnterprise(Enterprise $enterprise)
    {
        $this->enterprise = $enterprise;
    }
}
