<?php

namespace Tests\Unit\Foundation\Model\RoutableTest;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Illuminate\Database\Eloquent\Model;

class Gamma extends Model
{
    use Routable;

    protected $fillable = [
        'id',
    ];

    protected $attributes = [
        'id' => 789,
    ];

    protected $routePrefix = "alpha.beta.gamma";

    protected $routeParameterAliases = [
        'betum' => "beta",
    ];

    public function beta()
    {
        return $this->belongsTo(Beta::class)->withDefault(function ($beta) {
            $beta->exists = true;
            return $beta;
        });
    }
}
