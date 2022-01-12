<?php

namespace Tests\Unit\App\Models\Sogetrel\User;

use App\Models\Addworking\User\User;
use App\Models\Sogetrel\User\Passwork;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PassworkTest extends TestCase
{
    use RefreshDatabase;

    public function testOperationalManager()
    {
        $passwork = factory(Passwork::class)->create();

        $operational_manager = factory(User::class)->create();

        $passwork->operationalManager()->associate($operational_manager)->save();

        $this->assertEquals(
            $operational_manager,
            $passwork->operationalManager,
            "The passwork should have the expected operational manager"
        );
    }

    public function testContractSignatory()
    {
        $passwork = factory(Passwork::class)->create();

        $contract_signatory = factory(User::class)->create();

        $passwork->contractSignatory()->associate($contract_signatory)->save();

        $this->assertEquals(
            $contract_signatory,
            $passwork->contractSignatory,
            "The passwork should have the expected signatory"
        );
    }
}
