<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Components\Infrastructure\DatabaseCommands\Helpers\ModelFinder;

if (! function_exists('exists')) {
    function exists($model, $default = null)
    {
        return App::make('laravel-models')->exists($model, $default);
    }
}

if (! function_exists('is_model')) {
    function is_model($object): bool
    {
        return App::make('laravel-models')->isModel($object);
    }
}

if (! function_exists('find')) {
    function find($id): ?Model
    {
        return App::make('laravel-models')->find($id);
    }
}

if (! function_exists('find_all')) {
    function find_all(...$id): Collection
    {
        return App::make('laravel-models')->findAll($id);
    }
}

if (! function_exists('get_model_classes')) {
    function get_model_classes()
    {
        return App::make('laravel-models')->classes();
    }
}

if (! function_exists('get_model_from_object')) {
    function get_model_from_object(string $class, $obj): ?Model
    {
        return App::make('laravel-models')->getModelFromObject($class, $obj);
    }
}

if (! function_exists('get_model_from_array')) {
    function get_model_from_array(string $class, $arr): ?Model
    {
        return App::make('laravel-models')->getModelFromArray($class, $arr);
    }
}

if (! function_exists('get_model_from_id')) {
    function get_model_from_id(string $class, $id): ?Model
    {
        return App::make('laravel-models')->getModelFromId($class, $id);
    }
}

if (! function_exists('get_model_from_name')) {
    function get_model_from_name($class, $str): ?Model
    {
        return App::make('laravel-models')->getModelFromName($class, $str);
    }
}

if (! function_exists('get_model_from_number')) {
    function get_model_from_number(string $class, $num): ?Model
    {
        return App::make('laravel-models')->getModelFromNumber($class, $num);
    }
}

if (! function_exists('get_model_from_email')) {
    function get_model_from_email(string $class, $email): ?Model
    {
        return App::make('laravel-models')->getModelFromEmail($class, $email);
    }
}

if (! function_exists('get_empty_model')) {
    function get_empty_model(string $class): Model
    {
        return App::make('laravel-models')->getEmptyModel($class);
    }
}

if (! function_exists('get_model')) {
    function get_model(string $class, $arg)
    {
        return App::make('laravel-models')->get($class, $arg);
    }
}
