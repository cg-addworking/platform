<?php

namespace Tests\Unit\App\Models\Addworking\Billing;

use App\Models\Addworking\Billing\DeadlineType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Components\Infrastructure\Foundation\Application\Test\ModelTestCase;

class DeadlineTypeTest extends ModelTestCase
{
    protected $class = DeadlineType::class;
}
