<?php

namespace Tests\Unit\App\Repositories\Addworking\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\AddworkingEnterpriseRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddworkingEnterpriseRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testConstruct()
    {
        $repo = $this->app->make(AddworkingEnterpriseRepository::class);

        $this->assertInstanceOf(
            RepositoryInterface::class,
            $repo,
            "The repository should implements App\\Contracts\\RepositoryInterface"
        );
    }

    public function testGetAddworkingEnterprise()
    {
        $repo = $this->app->make(AddworkingEnterpriseRepository::class);

        $this->assertDatabaseMissing(
            (new Enterprise)->getTable(),
            ['name' => "ADDWORKING"],
        );

        $addworking = $repo->getAddworkingEnterprise();

        $this->assertInstanceOf(
            Enterprise::class,
            $addworking,
            "AddworkingEnterpriseRepository::getAddworkingEnterprise should provide an instance of Enterprise"
        );

        $this->assertTrue(
            $addworking->exists,
            "AddworkingEnterpriseRepository::getAddworkingEnterprise shoud provide an existing instance"
        );

        $this->assertDatabaseHas(
            (new Enterprise)->getTable(),
            ['name' => "ADDWORKING"],
        );

        $this->assertTrue(
            $addworking->users()->exists(),
            "The created Addworking enterprise should have users"
        );
    }
}
