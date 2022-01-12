<?php

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

class SigningHub extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'signinghub';
    }
}
