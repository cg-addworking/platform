<?php

namespace Tests\Feature\App\Repositories;

use App\Http\Controllers\Addworking\Enterprise\EnterpriseController;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Repositories\RepositoryManager;
use App\Support\Facades\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class RepositoryManagerTest extends TestCase
{
    public function testGetWithModelInstance()
    {
        $manager = $this->app->make(RepositoryManager::class);

        $this->assertInstanceOf(
            EnterpriseRepository::class,
            $manager->get(new Enterprise),
        );
    }

    public function testGetWithModelClassname()
    {
        $manager = $this->app->make(RepositoryManager::class);

        $this->assertInstanceOf(
            EnterpriseRepository::class,
            $manager->get(Enterprise::class),
        );
    }

    public function testGetWithContainerName()
    {
        $this->app->bind('enterprise', EnterpriseRepository::class);

        $manager = $this->app->make(RepositoryManager::class);

        $this->assertInstanceOf(
            EnterpriseRepository::class,
            $manager->get('enterprise'),
        );
    }

    public function testGetWithRepositoryClassname()
    {
        $manager = $this->app->make(RepositoryManager::class);

        $this->assertInstanceOf(
            EnterpriseRepository::class,
            $manager->get(EnterpriseRepository::class),
        );
    }

    public function testGetWithInvalidClassname()
    {
        $this->expectException(\RuntimeException::class);

        $manager = $this->app->make(RepositoryManager::class);

        $manager->get(EnterpriseController::class);
    }

    public function testGetWithUnregisteredContainerName()
    {
        $this->expectException(\RuntimeException::class);

        $manager = $this->app->make(RepositoryManager::class);

        $this->assertInstanceOf(
            EnterpriseRepository::class,
            $manager->get('enterprise-repository'),
        );
    }

    public function testFacadeWithModelInstance()
    {
        $this->assertInstanceOf(
            EnterpriseRepository::class,
            Repository::get(new Enterprise),
        );
    }

    public function testFacadeWithAliasedMethodName()
    {
        $this->app->bind('enterprise', EnterpriseRepository::class);

        $this->assertInstanceOf(
            EnterpriseRepository::class,
            Repository::enterprise(),
        );
    }

    public function testFacadeWithConfiguredMethodName()
    {
        Config::set('repositories.enterprise', EnterpriseRepository::class);

        $this->assertInstanceOf(
            EnterpriseRepository::class,
            Repository::enterprise(),
        );
    }
}
