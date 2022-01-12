<?php

namespace Components\Infrastructure\DatabaseCommands\Helpers;

use Illuminate\Support\Facades\Facade;

class Models extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-models';
    }
}
