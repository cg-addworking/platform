<?php

namespace Components\Mission\Offer\Application\Repositories;

use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Components\Mission\Offer\Domain\Interfaces\Repositories\JobRepositoryInterface;
use Illuminate\Support\Facades\App;

class JobRepository implements JobRepositoryInterface
{
    public function getJobsOf(Enterprise $enterprise)
    {
        return Job::whereHas('enterprise', function ($query) use ($enterprise) {
            $ancestors = App::make(FamilyEnterpriseRepository::class)->getAncestors($enterprise, true);
            return $query->whereIn('id', $ancestors->pluck('id'));
        })->with('skills')->cursor();
    }
}
