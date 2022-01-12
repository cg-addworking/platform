<?php

namespace Tests\Unit\App\Repositories\Addworking\User;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\User\AddworkingUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddworkingUserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testConstruct()
    {
        $repo = $this->app->make(AddworkingUserRepository::class);

        $this->assertInstanceOf(
            RepositoryInterface::class,
            $repo,
            "AddworkingUserRepository should implement App\\Contracts\\RepositoryInterface"
        );
    }

    public function testGetJulienPeronaUser()
    {
        $repo = $this->app->make(AddworkingUserRepository::class);

        $this->assertDatabaseMissing(
            (new User)->getTable(),
            ['email' => "julien@addworking.com"]
        );

        $user = $repo->getJulienPeronaUser();

        $this->assertDatabaseHas(
            (new User)->getTable(),
            ['email' => "julien@addworking.com"]
        );

        $this->assertInstanceOf(
            User::class,
            $user,
            "The created user should be an instance of " . User::class
        );

        $this->assertTrue(
            $user->exists,
            "The created user should exist"
        );

        $this->assertTrue(
            $user->enterprise->exists,
            "The created user should have an enterprise",
        );
    }

    public function testGetSystemUser()
    {
        $repo = $this->app->make(AddworkingUserRepository::class);

        $this->assertDatabaseMissing(
            (new User)->getTable(),
            ['email' => "system@addworking.com"]
        );

        $user = $repo->getSystemUser();

        $this->assertDatabaseHas(
            (new User)->getTable(),
            ['email' => "system@addworking.com"]
        );

        $this->assertInstanceOf(
            User::class,
            $user,
            "The created user should be an instance of " . User::class
        );

        $this->assertTrue(
            $user->exists,
            "The created user should exist"
        );
    }
}
