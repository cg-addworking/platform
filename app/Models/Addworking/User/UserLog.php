<?php

namespace App\Models\Addworking\User;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLog extends Model implements Htmlable
{
    use Viewable,
        Routable,
        SoftDeletes;

    protected $connection = 'pgsql_log';
    protected $table = 'addworking_user_logs';

    protected $fillable = [
        'user_id',
        'route',
        'url',
        'http_method',
        'ip',
        'input',
        'headers',
        'impersonating',
    ];

    protected $casts = [
        'impersonating' => 'bool',
        'input'         => 'array',
        'headers'       => 'array',
    ];

    protected $routePrefix = "log.user";
}
