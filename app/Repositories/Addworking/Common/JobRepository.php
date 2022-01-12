<?php

namespace App\Repositories\Addworking\Common;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class JobRepository extends BaseRepository
{
    protected $model = Job::class;

    public function createFromRequest(Request $request, Enterprise $enterprise): Job
    {
        $name = str_slug($request->input('job.display_name'));
        $job = $this->make(@compact('name') + $request->input('job'));
        $job->enterprise()->associate($enterprise);
        $job->save();

        return $job;
    }

    public function updateFromRequest(Request $request, Enterprise $enterprise, Job $job): Job
    {
        $name = str_slug($request->input('job.display_name', $job->display_name));
        $this->update($job, @compact('name') + $request->input('job'));

        return $job;
    }

    public function getJobsFromAllAncestors(Enterprise $enterprise, bool $include_self = false)
    {
        $ancestors = App::make(FamilyEnterpriseRepository::class)->getAncestors($enterprise, $include_self);

        return new Collection(
            $ancestors->map(fn($enterprise) => $enterprise->jobs)
                ->flatten()->unique('id')
        );
    }
}
