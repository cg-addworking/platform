<?php

namespace Components\Billing\Outbound\Domain\Classes;

use Illuminate\Database\Eloquent\Model;

interface FeeCsvBuilderInterface
{
    public function normalize(Model $model): array;
}
