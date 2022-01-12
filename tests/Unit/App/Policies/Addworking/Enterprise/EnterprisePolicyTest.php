<?php

namespace Tests\Unit\App\Policies\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Models\Sogetrel\Enterprise\Data;
use App\Policies\Addworking\Enterprise\EnterprisePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnterprisePolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testShow()
    {
        $policy = $this->app->make(EnterprisePolicy::class);

        $this->assertTrue(
            $policy->show(
                factory(User::class)->states('support')->create(),
                factory(Enterprise::class)->create()
            ),
            "Support user should be able to show any enterprise"
        );

        $this->assertTrue(
            $policy->show(
                $user = tap(factory(User::class)->create(), function ($user) {
                    $user->enterprises()->attach(
                        factory(Enterprise::class)->states('vendor')->create(),
                        ['is_admin' => true]
                    );
                }),
                $user->enterprise
            ),
            "Admin vendor user should be able to show their enterprise"
        );

        $this->assertTrue(
            $policy->show(
                $user = tap(factory(User::class)->create(), function ($user) {
                    $user->enterprises()->attach(
                        factory(Enterprise::class)->states('customer')->create(),
                        ['is_admin' => true]
                    );
                }),
                $user->enterprise
            ),
            "Admin customer user should be able to show their enterprise"
        );

        $this->assertTrue(
            $policy->show(
                $user = tap(factory(User::class)->create(), function ($user) {
                    $user->enterprises()->attach(
                        factory(Enterprise::class)->states('vendor')->create(),
                        ['is_admin' => true]
                    );
                    $user->enterprise->customers()->attach(
                        factory(Enterprise::class)->states('customer')->create()
                    );
                }),
                $user->enterprise
            ),
            "Vendor users should be able to show their customer's enterprises"
        );

        $this->assertTrue(
            $policy->show(
                $user = tap(factory(User::class)->create(), function ($user) {
                    $user->enterprises()->attach(
                        factory(Enterprise::class)->states('customer')->create(),
                        ['is_admin' => true]
                    );
                    $user->enterprise->vendors()->attach(
                        factory(Enterprise::class)->states('vendor')->create()
                    );
                }),
                $user->enterprise->vendors()->first()
            ),
            "Customer users should be able to show their vendor's enterprises"
        );

        $this->assertTrue(
            $policy->show(
                $user = tap(factory(User::class)->create(), function ($user) {
                    $user->enterprises()->attach(
                        tap(factory(Enterprise::class)->make(), function ($child) {
                            $child->parent()->associate(
                                factory(Enterprise::class)->create()
                            )->save();
                        }),
                        ['is_admin' => true]
                    );
                }),
                $user->enterprise->parent
            ),
            "User should be able to show their parent enterprises"
        );


        $this->assertTrue(
            $policy->show(
                $user = tap(factory(User::class)->create(), function ($user) {
                    $user->enterprises()->attach(
                        tap(factory(Enterprise::class)->create(), function ($parent) {
                            factory(Enterprise::class)->make()->parent()->associate($parent)->save();
                        })
                    );
                }),
                $user->enterprise->children()->first()
            ),
            "User should be able to show their children enterprises"
        );

        $this->assertFalse(
            $policy->show(
                factory(User::class)->create(),
                factory(Enterprise::class)->create()
            ),
            "User should not be able to show an enterprise he has not relationship with"
        );
    }

    public function testShowSogetrelData()
    {
        $enterprise    = factory(Enterprise::class)->create();
        $sogetrel_data = factory(Data::class)->make()->enterprise()->associate($enterprise)->save();

        $random_user   = factory(User::class)->create();
        $support_user  = factory(User::class)->states('support')->create();
        $sogetrel_user = factory(User::class)->create();

        $sogetrel      = factory(Enterprise::class)->create(['name' => "SOGETREL"]);
        $sogetrel->users()->attach($sogetrel_user, ['is_admin' => true]);

        $policy = $this->app->make(EnterprisePolicy::class);

        $this->assertFalse(
            $policy->showSogetrelData($random_user, $enterprise),
            "A random user should not be able to see Sogetrel data"
        );

        $this->assertTrue(
            $policy->showSogetrelData($support_user, $enterprise),
            "A support user should be able to see Sogetrel data"
        );

        $this->assertTrue(
            $policy->showSogetrelData($sogetrel_user, $enterprise),
            "A Sogetrel operator should be able to see Sogetrel data"
        );
    }

    public function testIndexMember()
    {
        $customer = tap(factory(Enterprise::class)->state('customer')->create(), function ($customer) {
            tap(factory(Enterprise::class)->state('vendor')->create(), function ($vendor) use ($customer) {
                tap(factory(User::class)->create(), function ($user) use ($vendor) {
                    $vendor->users()->attach($user, ['is_admin' => true]);
                });
                $customer->vendors()->attach($vendor);
            });
        });

        $policy = $this->app->make(EnterprisePolicy::class);

        $this->assertFalse(
            $policy->indexMember($customer->vendors->first()->users->first(), $customer)->allowed(),
            "A vendor user should not see members list of its customer"
        );
    }

    public function testHasInformationPolicy()
    {
        $customer = tap(factory(Enterprise::class)->state('customer')->create(), function ($customer) {
            tap(factory(Enterprise::class)->state('vendor')->create(), function ($vendor) use ($customer) {
                tap(factory(User::class)->create(), function ($user) use ($vendor) {
                    $vendor->users()->attach($user, ['is_admin' => true]);
                });
                $customer->vendors()->attach($vendor);
            });
        });

        $policy = $this->app->make(EnterprisePolicy::class);

        $this->assertFalse(
            $policy->viewPhoneNumbersInfo($customer->vendors->first()->users->first(), $customer)->allowed(),
            "A vendor user should not see the phone numbers of its customer"
        );

        $this->assertFalse(
            $policy->viewIbanInfo($customer->vendors->first()->users->first(), $customer)->allowed(),
            "A vendor user should not see the iban of its customer"
        );

        $this->assertFalse(
            $policy->viewCustomersInfo($customer->vendors->first()->users->first(), $customer)->allowed(),
            "A vendor user should not see customers of its customer"
        );

        $this->assertFalse(
            $policy->viewIdInfo($customer->vendors->first()->users->first(), $customer)->allowed(),
            "A vendor user should not see Id of its customer"
        );

        $this->assertFalse(
            $policy->viewIdInfo($customer->vendors->first()->users->first(), $customer)->allowed(),
            "A vendor user should not see number of its customer"
        );

        $this->assertFalse(
            $policy->viewClientIdInfo($customer->vendors->first()->users->first(), $customer)->allowed(),
            "A vendor user should not see client id of its customer"
        );

        $this->assertFalse(
            $policy->viewTimestampInfo($customer->vendors->first()->users->first(), $customer)->allowed(),
            "A vendor user should not see the creation and update dates of its customer"
        );

        $this->assertFalse(
            $policy->viewTagsInfo($customer->vendors->first()->users->first(), $customer)->allowed(),
            "A vendor user should not see the tags of its customer"
        );
    }
}
