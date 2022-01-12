<?php

namespace Tests\Unit\Foundation\Model\RoutableTest;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Illuminate\Database\Eloquent\Model;

class Alpha extends Model
{
    use Routable;

    protected $fillable = [
        'id',
    ];

    protected $attributes = [
        'id' => 123,
    ];
}
