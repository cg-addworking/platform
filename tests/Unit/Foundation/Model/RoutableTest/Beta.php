<?php

namespace Tests\Unit\Foundation\Model\RoutableTest;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Illuminate\Database\Eloquent\Model;

class Beta extends Model
{
    use Routable;

    protected $fillable = [
        'id',
    ];

    protected $attributes = [
        'id' => 456,
    ];

    protected $routePrefix = "alpha.beta";

    protected $routeParameterAliases = [
        'betum' => "beta",
    ];

    public function alpha()
    {
        return $this->belongsTo(Alpha::class)->withDefault(function ($alpha) {
            $alpha->exists = true;
            return $alpha;
        });
    }
}
