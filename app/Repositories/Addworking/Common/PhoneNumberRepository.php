<?php

namespace App\Repositories\Addworking\Common;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Common\PhoneNumber;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class PhoneNumberRepository extends BaseRepository
{
    protected $model = PhoneNumber::class;

    /**
     * Create a new model.
     *
     * @param  array|string $data
     * @return Model
     */
    public function create($data): Model
    {
        if (is_string($data)) {
            $data = ['number' => $data];
        }

        if (! ($model = PhoneNumber::firstOrNew($data))->exists) {
            $model->save();
        }

        return $model;
    }
}
