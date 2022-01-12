<?php

namespace Tests\Unit\App\Policies\Addworking\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\User\User;
use App\Policies\Addworking\Mission\ProposalResponsePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProposalResponsePolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $policy = $this->app->make(ProposalResponsePolicy::class);

        $this->assertTrue(
            $policy->index(
                factory(User::class)->states('support')->create(),
                factory(Proposal::class)->create()
            ),
            "Support should be able to index proposals"
        );

        $proposal = factory(Proposal::class)->create();

        $vendor = factory(Enterprise::class)->states('vendor')->create();

        $this->assertFalse(
            $policy->index(
                $vendor->users()->first(),
                $proposal
            ),
            "vendor not attached to the proposal should not be able to index responses for the given proposal"
        );

        $proposal->vendor()->associate($vendor)->save();

        $this->assertTrue(
            $policy->index(
                $vendor->users()->first(),
                $proposal
            ),
            "proposal vendor should be able to index responses for the given proposal"
        );

        $customer = factory(Enterprise::class)->states('customer')->create();

        $this->assertFalse(
            $policy->index(
                $customer->users()->first(),
                $proposal
            ),
            "customer not attached to the proposal offer should not be able to index responses for the given proposal"
        );

        $proposal->offer->customer()->associate($customer)->save();

        $this->assertTrue(
            $policy->index(
                $customer->users()->first(),
                $proposal
            ),
            "customer not attached to the proposal offer should not be able to index responses for the given proposal"
        );
    }

    public function testIndexOfferAnswers()
    {
        $policy = $this->app->make(ProposalResponsePolicy::class);

        $this->assertTrue(
            $policy->indexOfferAnswers(
                factory(User::class)->states('support')->create(),
                factory(Proposal::class)->create()->offer
            )->allowed(),
            "Support users should be able to index responses of the given offer"
        );

        $proposal = factory(Proposal::class)->create();

        $customer = factory(Enterprise::class)->states('customer')->create();

        $this->assertFalse(
            $policy->indexOfferAnswers(
                $customer->users()->first(),
                $proposal->offer
            )->allowed(),
            "customer not attached to the offer should not be able to index responses for the given offer"
        );

        $proposal->offer->customer()->associate($customer)->save();

        $this->assertTrue(
            $policy->indexOfferAnswers(
                $customer->users()->first(),
                $proposal->offer
            )->allowed(),
            "customer attached to the offer should be able to index responses for the given offer"
        );
    }

    public function testCreate()
    {
        $policy = $this->app->make(ProposalResponsePolicy::class);

        $this->assertTrue(
            $policy->create(
                factory(User::class)->states('support')->create(),
                factory(Proposal::class)->create()
            ),
            "Support should be able to create proposal"
        );

        $proposal = factory(Proposal::class)->states('status_received')->create();

        $vendor = factory(Enterprise::class)->states('vendor')->create();

        $this->assertFalse(
            $policy->create(
                $vendor->users()->first(),
                $proposal
            ),
            "vendor not attached to the proposal should not be able to create response for the given proposal"
        );

        $proposal->vendor()->associate($vendor)->save();

        $this->assertTrue(
            $policy->create(
                $vendor->users()->first(),
                $proposal
            ),
            "proposal vendor should be able to create response for the given proposal"
        );

        $sogetrel = factory(Enterprise::class)->states('customer')->create(['name' => "SOGETREL"]);

        $customer = factory(Enterprise::class)->states('customer')->create();
        $customer->parent()->associate($sogetrel)->save();

        $customer->vendors()->syncWithoutDetaching($vendor);

        $proposal->offer->customer()->associate($customer);

        $this->assertFalse(
            $policy->create(
                $vendor->users()->first(),
                $proposal
            ),
            "sogetrel vendor should not be able to create response for the given proposal if its status is received"
        );

        $proposal->update(['status' => Proposal::STATUS_INTERESTED]);

        $this->assertFalse(
            $policy->create(
                $vendor->users()->first(),
                $proposal
            ),
            "sogetrel vendor should not be able to create response for the given proposal if its status is interested"
        );

        $proposal->update(['status' => Proposal::STATUS_BPU_SENDED]);

        $this->assertTrue(
            $policy->create(
                $vendor->users()->first(),
                $proposal
            ),
            "sogetrel vendor should be able to create response if its status is not received or interested"
        );
    }
}
