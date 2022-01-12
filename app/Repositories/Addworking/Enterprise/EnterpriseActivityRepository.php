<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseActivity;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnterpriseActivityRepository extends BaseRepository
{
    protected $model = EnterpriseActivity::class;

    /**
     * Creates an enterprise activity from the given request.
     *
     * @param  Request $request
     * @return EnterpriseActivity
     */
    public function createFromRequest(Request $request): EnterpriseActivity
    {
        return DB::transaction(function () use ($request) {
            $activity = $this->make($request->input('enterprise_activity'));

            $activity
                ->enterprise()
                ->associate($request->input('enterprise.id'));

            $activity->save();

            $activity
                ->departments()
                ->sync($request->input('enterprise_activity.departments'));

            return $activity;
        });
    }

    public function getActivityOf(Enterprise $enterprise): EnterpriseActivity
    {
        return $enterprise->activities()->firstOrNew([]);
    }

    public function getEmployeesCount(Enterprise $enterprise): int
    {
        $total = 0;

        foreach ($enterprise->activities as $activity) {
            $total += $activity->employees_count;
        }

        return $total;
    }
}
