<?php

namespace App\Repositories\Addworking\Common;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Common\Address;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class AddressRepository extends BaseRepository
{
    protected $model = Address::class;

    /**
     * Create a new model.
     *
     * @param  array $data
     * @return Model
     */
    public function create($data): Model
    {
        return Address::firstOrCreate($data);
    }
}
