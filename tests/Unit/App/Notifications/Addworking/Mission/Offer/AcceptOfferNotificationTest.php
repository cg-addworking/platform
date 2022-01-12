<?php

namespace Tests\Unit\App\Notifications\Addworking\Mission\Offer;

use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\Mission\ProposalResponse;
use App\Models\Addworking\User\User;
use App\Notifications\Addworking\Mission\Offer\AcceptOfferNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AcceptOfferNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function testToMail()
    {
        $response = factory(ProposalResponse::class)->create();
        $vendor = $response->proposal->vendor;

        Notification::fake();
        Notification::assertNothingSent();

        Notification::send(
            $vendor->users()->first(),
            new AcceptOfferNotification($response->proposal->offer, $response->proposal)
        );

        Notification::assertSentTo($vendor->users()->first(), AcceptOfferNotification::class);
    }
}
