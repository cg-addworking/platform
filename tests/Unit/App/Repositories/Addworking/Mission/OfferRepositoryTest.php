<?php

namespace Tests\Unit\App\Repositories\Addworking\Mission;

use App\Models\Addworking\Mission\Offer;
use App\Repositories\Addworking\Mission\OfferRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfferRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testClose()
    {
        $offer = factory(Offer::class)->states('draft')->create();

        $repository = $this->app->make(OfferRepository::class);

        $this->assertTrue(
            $repository->close($offer),
            "Closing mission should be successful"
        );

        $this->assertTrue(
            $offer->fresh()->isClosed(),
            "Offer should be closed"
        );
    }
}
