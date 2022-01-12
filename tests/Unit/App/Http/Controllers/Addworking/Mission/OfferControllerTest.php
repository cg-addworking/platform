<?php

namespace Tests\Unit\App\Http\Controllers\Addworking\Mission;

use App\Http\Controllers\Addworking\Mission\OfferController;
use App\Http\Controllers\Controller;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class OfferControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testConstruct()
    {
        $controller = $this->app->make(OfferController::class);

        $this->assertInstanceof(
            Controller::class,
            $controller
        );
    }

    public function testClose()
    {
        $offer = factory(Offer::class)->states('communicated')->create();
        $user = $offer->createdBy;
        $user->hasAccessToMissionFor($offer->customer);

        $response = $this->actingAs($user)->post('mission-offer/'.$offer->id.'/close');
        $response->assertStatus(302);
        $response->assertRedirect(route('enterprise.offer.summary', [$offer->customer, $offer]));
    }
}
