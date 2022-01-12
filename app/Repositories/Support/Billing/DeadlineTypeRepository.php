<?php

namespace App\Repositories\Support\Billing;

use App\Contracts\Models\Repository;
use App\Repositories\BaseRepository;
use App\Models\Addworking\Billing\DeadlineType;
use Illuminate\Http\Request;

class DeadlineTypeRepository extends BaseRepository
{
    protected $model = DeadlineType::class;

    public function createFromRequest(Request $request): DeadlineType
    {
        return $this->updateFromRequest($request, $this->make());
    }

    public function updateFromRequest(Request $request, DeadlineType $deadline_type): DeadlineType
    {
        return tap($deadline_type, function ($type) use ($request) {
            $type->fill(['name'  => $request->input('deadline_type.display_name'),] + $request->input('deadline_type'))
                ->save();
        });
    }
}
