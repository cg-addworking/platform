<?php

namespace Components\Mission\Offer\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;

interface JobRepositoryInterface
{
    public function getJobsOf(Enterprise $enterprise);
}
