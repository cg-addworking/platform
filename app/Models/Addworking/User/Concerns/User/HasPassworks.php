<?php

namespace App\Models\Addworking\User\Concerns\User;

use App\Models\Addworking\Common\Passwork;
use App\Models\Sogetrel\User\Passwork as SogetrelPasswork;
use App\Models\Sogetrel\User\PassworkSavedSearch;
use App\Models\Sogetrel\User\PassworkSavedSearchSchedule;

trait HasPassworks
{
    public function passworks()
    {
        return $this->morphMany(Passwork::class, 'passworkable');
    }

    public function passworkSavedSearchesSchedule()
    {
        return $this->hasMany(PassworkSavedSearchSchedule::class);
    }

    public function passworkSavedSearches()
    {
        return $this->hasMany(PassworkSavedSearch::class);
    }

    public function sogetrelPasswork()
    {
        return $this->hasOne(SogetrelPasswork::class)->latest()->withDefault();
    }
}
