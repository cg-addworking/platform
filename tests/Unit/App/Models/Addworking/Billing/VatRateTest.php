<?php

namespace Tests\Unit\App\Models\Addworking\Billing;

use App\Models\Addworking\Billing\VatRate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Components\Infrastructure\Foundation\Application\Test\ModelTestCase;

class VatRateTest extends ModelTestCase
{
    protected $class = VatRate::class;
}
