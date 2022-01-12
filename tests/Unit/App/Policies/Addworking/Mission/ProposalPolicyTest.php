<?php

namespace Tests\Unit\App\Policies\Addworking\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\User\User;
use App\Policies\Addworking\Mission\ProposalPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProposalPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $policy = $this->app->make(ProposalPolicy::class);

        $this->assertTrue(
            $policy->index(
                factory(User::class)->states('support')->create()
            ),
            "Support users should be able to index proposals"
        );

        $this->assertFalse(
            $policy->index(
                tap(factory(Enterprise::class)->states('customer')->create(), function ($customer) {
                    $customer->vendors()->attach(
                        factory(Enterprise::class, 5)->states('vendor')->create()
                    );
                })->users()->first()
            ),
            "Customers should not be able to index proposals"
        );

        $this->assertTrue(
            $policy->index(
                tap(factory(Enterprise::class)->states('vendor')->create(), function ($vendor) {
                    $vendor->customers()->attach(
                        factory(Enterprise::class)->states('customer')->create()
                    );
                })->users()->first()
            ),
            "Vendors should be able to index proposals"
        );

        $sogetrel = factory(Enterprise::class)->states('customer')->create(['name' => "SOGETREL"]);

        $this->assertTrue(
            $policy->index(
                $sogetrel->users()->first()
            ),
            "Sogetrel members should be able to index proposals"
        );

        $this->assertTrue(
            $policy->index(
                tap(factory(Enterprise::class)->states('customer')->create(), function ($customer) use ($sogetrel) {
                    $customer->parent()->associate(
                        $sogetrel
                    )->save();
                })->users()->first()
            ),
            "Members of subsidiaries of Sogetrel should be able to index proposals"
        );
    }

    public function testStoreBpu()
    {
        $policy = $this->app->make(ProposalPolicy::class);

        $this->assertTrue(
            $policy->storeBpu(
                factory(User::class)->states('support')->create(),
                factory(Proposal::class)->create()
            ),
            'Support user should be able to store bpu in proposal'
        );
    }

    public function testSeeSogetrelAlert()
    {
        $policy = $this->app->make(ProposalPolicy::class);

        $proposal = factory(Proposal::class)->states('status_interested')->create();

        $vendor = factory(Enterprise::class)->states('vendor')->create();

        $this->assertFalse(
            $policy->seeSogetrelAlert(
                $vendor->users()->first(),
                $proposal
            ),
            "vendor not attached to the proposal should not be able to see alert"
        );

        $proposal->vendor()->associate($vendor)->save();

        $this->assertFalse(
            $policy->seeSogetrelAlert(
                $vendor->users()->first(),
                $proposal
            ),
            "proposal vendor not member of sogetrel vendors should not be able to see the alert"
        );

        $proposal = tap(factory(Proposal::class)->states('status_interested')->create(), function ($proposal) {
            $proposal->offer->customer()->associate(
                tap(factory(Enterprise::class)->state('customer')->create(), function ($customer) {
                    $customer->parent()->associate(
                        factory(Enterprise::class)->state('customer')->create(['name' => "SOGETREL"])
                    )->save();
                })
            )->save();

            $proposal->vendor()->associate(
                tap(factory(Enterprise::class)->state('vendor')->create(), function ($vendor) use ($proposal) {
                    $proposal->offer->customer->vendors()->syncWithoutDetaching($vendor);
                })
            )->save();
        });

        $this->assertTrue(
            $policy->seeSogetrelAlert(
                $proposal->vendor->users()->first(),
                $proposal
            ),
            "sogetrel vendor should be able to see the alert"
        );

        $this->assertFalse(
            $policy->seeSogetrelAlert(
                $proposal->offer->customer->users()->first(),
                $proposal
            ),
            "sogetrel customer should not be able to see the  alert"
        );
    }
}
