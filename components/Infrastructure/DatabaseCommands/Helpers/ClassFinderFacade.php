<?php

namespace Components\Infrastructure\DatabaseCommands\Helpers;

use Illuminate\Support\Facades\Facade;

class ClassFinderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'class-finder';
    }
}
