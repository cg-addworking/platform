<?php

namespace Tests\Unit\App\Policies\Addworking\Mission;

use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\User\User;
use App\Policies\Addworking\Mission\OfferPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfferPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testBroadcast()
    {
        $policy = $this->app->make(OfferPolicy::class);

        $this->assertTrue(
            $policy->broadcast(
                factory(User::class)->state('support')->create(),
                factory(Offer::class)->create()
            )->allowed(),
            "Support user should be allowed to broadcast an offer"
        );

        $user  = factory(User::class)->create();
        $offer = tap(factory(Offer::class)->create(), function ($offer) use ($user) {
            $offer->customer->users()->attach($user, [User::ACCESS_TO_MISSION => false]);
        });

        $this->assertTrue(
            $policy->broadcast($user, $offer)->denied(),
            "User without access to mission should not be allowed to broadcast offer"
        );

        $user  = factory(User::class)->create();
        $offer = tap(factory(Offer::class)->create(), function ($offer) use ($user) {
            $offer->customer->users()->attach($user, [User::IS_MISSION_OFFER_BROADCASTER => false]);
        });

        $this->assertTrue(
            $policy->broadcast($user, $offer)->denied(),
            "User without broadcasting role should not be allowed to broadcast offer"
        );

        $user  = factory(User::class)->create();
        $offer = tap(factory(Offer::class)->state('communicated')->create(), function ($offer) use ($user) {
            $offer->customer->users()->attach($user, [
                User::IS_MISSION_OFFER_BROADCASTER => true,
                User::ACCESS_TO_MISSION => true
            ]);
        });

        $this->assertTrue(
            $policy->broadcast($user, $offer)->denied(),
            "It should not be possible to broadcast an offer already broadcasted"
        );

        $user  = factory(User::class)->create();
        $offer = tap(factory(Offer::class)->create(), function ($offer) use ($user) {
            $offer->customer->users()->attach($user, [
                User::IS_MISSION_OFFER_BROADCASTER => true,
                User::ACCESS_TO_MISSION => true
            ]);
        });

        $this->assertTrue(
            $policy->broadcast($user, $offer)->allowed(),
            "User with the right privileges should be able to broadcast an offer"
        );
    }

    public function testClose()
    {
        $policy = $this->app->make(OfferPolicy::class);


        $this->assertTrue(
            $policy->close(
                factory(User::class)->state('support')->create(),
                factory(Offer::class)->create()
            )->allowed(),
            "Support user should be allowed to close an offer"
        );

        $user  = factory(User::class)->create();
        $offer = tap(factory(Offer::class)->create(), function ($offer) use ($user) {
            $offer->customer->users()->attach($user, [User::ACCESS_TO_MISSION => false]);
        });

        $this->assertTrue(
            $policy->close($user, $offer)->denied(),
            "User without access to mission should not be allowed to close offer"
        );

        $user  = factory(User::class)->create();
        $offer = tap(factory(Offer::class)->create(), function ($offer) use ($user) {
            $offer->customer->users()->attach($user, [User::IS_MISSION_OFFER_CLOSER => false]);
        });

        $this->assertTrue(
            $policy->close($user, $offer)->denied(),
            "User without closer role should not be allowed to close offer"
        );

        $user  = factory(User::class)->create();
        $offer = tap(factory(Offer::class)->state('closed')->create(), function ($offer) use ($user) {
            $offer->customer->users()->attach($user, [
                User::IS_MISSION_OFFER_CLOSER => true,
                User::ACCESS_TO_MISSION => true
            ]);
        });

        $this->assertTrue(
            $policy->close($user, $offer)->denied(),
            "It should not be possible to close an offer already closeed"
        );

        $user  = factory(User::class)->create();
        $offer = tap(factory(Offer::class)->state('communicated')->create(), function ($offer) use ($user) {
            $offer->customer->users()->attach($user, [
                User::IS_MISSION_OFFER_CLOSER => true,
                User::ACCESS_TO_MISSION => true
            ]);
        });

        $this->assertTrue(
            $policy->close($user, $offer)->allowed(),
            "User with the right privileges should be able to close an offer"
        );
    }
}
