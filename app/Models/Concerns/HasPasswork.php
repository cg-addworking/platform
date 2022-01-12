<?php

namespace App\Models\Concerns;

use App\Models\Addworking\Common\Passwork;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Sogetrel\User\Passwork as SogetrelPasswork;

trait HasPasswork
{
    protected $models = [
        \App\Models\Sogetrel\User\Passwork::class,
    ];

    public function passwork()
    {
        foreach ($this->models as $class) {
            if ($passwork = $class::where('enterprise_id', $this->id)->first()) {
                break;
            }
        }

        if (!isset($passwork)) {
            $passwork = app()->make(Passwork::class);
        }

        if ($this instanceof Enterprise) {
            $passwork->user()->associate($this->legalRepresentatives->first());
        }

        return $passwork;
    }

    public function sogetrelPasswork()
    {
        return $this->hasOne(SogetrelPasswork::class)->withDefault();
    }

    public function hasPasswork()
    {
        if ($this->sogetrelPasswork->exists) {
            return true;
        }

        return false;
    }
}
