<?php

namespace Tests\Behavior;

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Illuminate\Contracts\Console\Kernel;

trait RefreshDatabase
{
    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope)
    {
        $this->artisan('migrate');
        $this->app[Kernel::class]->setArtisan(null);
    }

    /** @AfterScenario */
    public function after(AfterScenarioScope $scope)
    {
        $this->artisan('migrate:rollback');
    }
}
