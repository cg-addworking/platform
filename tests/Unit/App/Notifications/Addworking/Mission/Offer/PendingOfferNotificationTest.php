<?php

namespace Tests\Unit\App\Notifications\Addworking\Mission\Offer;

use App\Models\Addworking\Mission\Proposal;
use App\Notifications\Addworking\Mission\Offer\PendingOfferNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PendingOfferNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function testToMail()
    {
        $proposal = factory(Proposal::class)->create();
        $user = $proposal->vendor->users()->first();

        Notification::fake();
        Notification::assertNothingSent();

        Notification::send(
            $user,
            new PendingOfferNotification($proposal->offer)
        );

        Notification::assertSentTo(
            $user,
            PendingOfferNotification::class,
            function ($notification, $channels) use ($proposal, $user) {
                $mail_data = $notification->toMail($user)->toArray();

                $this->assertEquals(
                    "Une offre de mission {$proposal->offer->customer} a été clôturée",
                    $mail_data['subject']
                );

                return $notification->offer->is($proposal->offer);
            }
        );
    }

    public function testToArray()
    {
        $proposal = factory(Proposal::class)->create();
        $user = $proposal->vendor->users()->first();

        Notification::fake();
        Notification::assertNothingSent();

        Notification::send(
            $user,
            new PendingOfferNotification($proposal->offer)
        );

        Notification::assertSentTo(
            $user,
            PendingOfferNotification::class,
            function ($notification, $channels) use ($proposal, $user) {
                $array_data = $notification->toArray($user);

                $this->assertEquals($array_data['label'], $proposal->offer->label);

                return $notification->offer->is($proposal->offer);
            }
        );
    }
}
