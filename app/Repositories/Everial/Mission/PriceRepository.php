<?php

namespace App\Repositories\Everial\Mission;

use App\Contracts\Models\Repository;
use App\Models\Everial\Mission\Price;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class PriceRepository extends BaseRepository
{
    protected $model = Price::class;
}
