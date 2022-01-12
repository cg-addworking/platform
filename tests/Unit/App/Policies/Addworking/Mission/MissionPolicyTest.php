<?php

namespace Tests\Unit\App\Policies\Addworking\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\User\User;
use App\Policies\Addworking\Mission\MissionPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MissionPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $policy = $this->app->make(MissionPolicy::class);

        $this->assertTrue(
            $policy->index(
                factory(User::class)->states('support')->create()
            ),
            "Support should be able to index missions"
        );

        $this->assertTrue(
            $policy->index(
                tap(factory(User::class)->create(), function ($user) {
                    $user->enterprises()->attach(
                        factory(Enterprise::class)->states('customer')->create(),
                        ['primary' => true, 'is_admin' => true]
                    );
                })
            ),
            "Customer user should be able to index missions"
        );

        $this->assertTrue(
            $policy->index(
                tap(factory(User::class)->create(), function ($user) {
                    $user->enterprises()->attach(
                        factory(Enterprise::class)->states('vendor')->create(),
                        ['primary' => true, 'is_admin' => true]
                    );
                })
            ),
            "Vendor user should be able to index missions"
        );

        $this->assertFalse(
            $policy->index(
                tap(factory(User::class)->create(), function ($user) {
                    $user->enterprises()->attach(
                        factory(Enterprise::class)->create(),
                        ['primary' => true, 'is_admin' => true, 'access_to_mission' => false]
                    );
                })
            ),
            "Users without 'access_to_mission' privilege shouldn't be able to index missions"
        );
    }

    public function testShow()
    {
        $policy  = $this->app->make(MissionPolicy::class);
        $mission = factory(Mission::class)->create();

        $this->assertTrue(
            $policy->show(
                factory(User::class)->state('support')->create(),
                $mission
            ),
            "Support user should be able to show mission"
        );

        $this->assertTrue(
            $policy->show(
                tap(factory(User::class)->create(), function ($user) use ($mission) {
                    $user->enterprises()->attach(
                        $mission->customer,
                        ['primary' => true, 'is_admin' => true]
                    );
                }),
                $mission
            ),
            "Customer user should be able to show mission"
        );

        $this->assertTrue(
            $policy->show(
                tap(factory(User::class)->create(), function ($user) use ($mission) {
                    $user->enterprises()->attach(
                        $mission->vendor,
                        ['primary' => true, 'is_admin' => true]
                    );
                }),
                $mission
            ),
            "Vendor user should be able to show mission"
        );

        $this->assertFalse(
            $policy->show(
                tap(factory(User::class)->create(), function ($user) {
                    $user->enterprises()->attach(
                        factory(Enterprise::class)->create(),
                        ['primary' => true, 'is_admin' => true]
                    );
                }),
                $mission
            ),
            "User enterprise should be attached to mission in order to be able to show mission"
        );

        $this->assertFalse(
            $policy->show(
                tap(factory(User::class)->create(), function ($user) use ($mission) {
                    $user->enterprises()->attach(
                        $mission->customer,
                        ['primary' => true, 'is_admin' => true, 'access_to_mission' => false]
                    );
                }),
                $mission
            ),
            "Customer user without access to mission shouldn't be able to show mission"
        );

        $this->assertFalse(
            $policy->show(
                tap(factory(User::class)->create(), function ($user) use ($mission) {
                    $user->enterprises()->attach(
                        $mission->vendor,
                        ['primary' => true, 'is_admin' => true, 'access_to_mission' => false]
                    );
                }),
                $mission
            ),
            "Vendor user without access to mission shouldn't be able to show mission"
        );
    }

    public function testCreate()
    {
        $policy = $this->app->make(MissionPolicy::class);

        $this->assertTrue(
            $policy->create(
                factory(User::class)->states('support')->create()
            ),
            "Support users should be able to create missions"
        );

        $this->assertFalse(
            $policy->create(
                factory(User::class)->states('non-support')->create()
            ),
            "Regular users shouldn't be able to create missions"
        );
    }

    public function testUpdate()
    {
        $policy  = $this->app->make(MissionPolicy::class);
        $mission = factory(Mission::class)->create();

        $this->assertTrue(
            $policy->update(
                factory(User::class)->states('support')->create(),
                $mission
            ),
            "Support user should be able to update mission"
        );

        $this->assertTrue(
            $policy->update(
                tap(factory(User::class)->create(), function ($user) use ($mission) {
                    $user->enterprises()->attach(
                        $mission->customer,
                        ['primary' => true, 'is_admin' => true]
                    );
                }),
                $mission
            ),
            "Mission's customer enterprise admin users should be able to update mission"
        );

        $this->assertTrue(
            $policy->update(
                tap(factory(User::class)->create(), function ($user) use ($mission) {
                    $user->enterprises()->attach(
                        $mission->customer,
                        ['primary' => true, 'is_operator' => true]
                    );
                }),
                $mission
            ),
            "Mission's customer enterprise operator users should be able to update mission"
        );

        $this->assertFalse(
            $policy->update(
                tap(factory(User::class)->create(), function ($user) use ($mission) {
                    $user->enterprises()->attach(
                        $mission->customer,
                        ['primary' => true, 'is_readonly' => true]
                    );
                }),
                $mission
            ),
            "Mission's customer enterprise readonly users shouldn't be able to update mission"
        );
    }

    public function testDestroy()
    {
        $policy  = $this->app->make(MissionPolicy::class);
        $mission = factory(Mission::class)->create();

        $this->assertTrue(
            $policy->destroy(
                factory(User::class)->states('support')->create(),
                $mission
            ),
            "Support user should be able to destroy mission"
        );

        $this->assertTrue(
            $policy->destroy(
                tap(factory(User::class)->create(), function ($user) use ($mission) {
                    $user->enterprises()->attach(
                        $mission->customer,
                        ['primary' => true, 'is_admin' => true]
                    );
                }),
                $mission
            ),
            "Mission's customer enterprise admin users should be able to destroy mission"
        );

        $this->assertTrue(
            $policy->destroy(
                tap(factory(User::class)->create(), function ($user) use ($mission) {
                    $user->enterprises()->attach(
                        $mission->customer,
                        ['primary' => true, 'is_operator' => true]
                    );
                }),
                $mission
            ),
            "Mission's customer enterprise operator users should be able to destroy mission"
        );

        $this->assertFalse(
            $policy->destroy(
                tap(factory(User::class)->create(), function ($user) use ($mission) {
                    $user->enterprises()->attach(
                        $mission->customer,
                        ['primary' => true, 'is_readonly' => true]
                    );
                }),
                $mission
            ),
            "Mission's customer enterprise readonly users shouldn't be able to destroy mission"
        );
    }

    public function testClose()
    {
        $policy  = $this->app->make(MissionPolicy::class);
        $mission = factory(Mission::class)->create();

        $this->assertTrue(
            $policy->close(
                factory(User::class)->states('support')->create(),
                $mission
            ),
            "Support user should be able to close mission"
        );

        $this->assertTrue(
            $policy->close(
                tap(factory(User::class)->create(), function ($user) use ($mission) {
                    $user->enterprises()->attach(
                        $mission->customer,
                        ['primary' => true, 'is_admin' => true]
                    );
                }),
                $mission
            ),
            "Mission's customer enterprise admin users should be able to close mission"
        );

        $this->assertTrue(
            $policy->close(
                tap(factory(User::class)->create(), function ($user) use ($mission) {
                    $user->enterprises()->attach(
                        $mission->customer,
                        ['primary' => true, 'is_operator' => true]
                    );
                }),
                $mission
            ),
            "Mission's customer enterprise operator users should be able to close mission"
        );

        $this->assertFalse(
            $policy->close(
                tap(factory(User::class)->create(), function ($user) use ($mission) {
                    $user->enterprises()->attach(
                        $mission->customer,
                        ['primary' => true, 'is_readonly' => true]
                    );
                }),
                $mission
            ),
            "Mission's customer enterprise readonly users shouldn't be able to close mission"
        );
    }
}
