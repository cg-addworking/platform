<?php

namespace Tests\Unit\App\Notifications\Addworking\Mission\Offer;

use App\Models\Addworking\Mission\Proposal;
use App\Notifications\Addworking\Mission\Offer\RefuseOfferNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RefuseOfferNotificationTest extends TestCase
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
            new RefuseOfferNotification($proposal->offer)
        );

        Notification::assertSentTo(
            $user,
            RefuseOfferNotification::class,
            function ($notification, $channels) use ($proposal, $user) {
                $mail_data = $notification->toMail($user)->toArray();

                $this->assertEquals(
                    "Votre réponse à une offre {$proposal->offer->customer} n’a pas été retenue",
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
            new RefuseOfferNotification($proposal->offer)
        );

        Notification::assertSentTo(
            $user,
            RefuseOfferNotification::class,
            function ($notification, $channels) use ($proposal, $user) {
                $array_data = $notification->toArray($user);

                $this->assertEquals($array_data['label'], $proposal->offer->label);

                return $notification->offer->is($proposal->offer);
            }
        );
    }
}
