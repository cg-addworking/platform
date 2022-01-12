<?php

namespace Tests\Unit\App\Models\Addworking\User\OnboardingProcess;

use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\OnboardingProcess\UndefinedStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UndefinedStepTest extends TestCase
{
    use RefreshDatabase;

    public function testPasses()
    {
        $step = new UndefinedStep(factory(OnboardingProcess::class)->create());

        $this->assertFalse($step->passes(), "Undefined step never passes");
    }
}
