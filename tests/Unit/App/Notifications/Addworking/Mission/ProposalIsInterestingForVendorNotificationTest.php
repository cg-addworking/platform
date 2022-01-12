<?php

namespace Tests\Unit\App\Notifications\Addworking\Mission;

use App\Models\Addworking\Mission\Proposal;
use App\Notifications\Addworking\Mission\ProposalIsInterestingForVendorNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ProposalIsInterestingForVendorNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function testToMail()
    {
        $proposal = factory(Proposal::class)->create();

        $referent = $proposal->offer->referent;

        Notification::fake();

        Notification::assertNothingSent();

        Notification::send(
            $referent,
            new ProposalIsInterestingForVendorNotification($proposal)
        );

        Notification::assertSentTo(
            $referent,
            ProposalIsInterestingForVendorNotification::class,
            function ($notification, $channels) use ($proposal, $referent) {
                $mail_data = $notification->toMail($referent)->toArray();

                $this->assertEquals(
                    "Un prestataire est interessé par votre offre {$proposal->offer->label}",
                    $mail_data['subject']
                );

                return $notification->proposal->is($proposal);
            }
        );
    }

    public function testToArray()
    {
        $proposal = factory(Proposal::class)->create();

        $referent = $proposal->offer->referent;

        Notification::fake();

        Notification::assertNothingSent();

        Notification::send(
            $referent,
            new ProposalIsInterestingForVendorNotification($proposal)
        );

        Notification::assertSentTo(
            $referent,
            ProposalIsInterestingForVendorNotification::class,
            function ($notification, $channels) use ($proposal, $referent) {
                $array_data = $notification->toArray($referent);

                $this->assertEquals($array_data['vendor_name'], $proposal->vendor->name);
                $this->assertEquals($array_data['offer_label'], $proposal->offer->label);
                $this->assertEquals($array_data['proposal_url'], $proposal->routes->show);

                return $notification->proposal->is($proposal);
            }
        );
    }
}
