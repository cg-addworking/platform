<?php

namespace Tests\Unit\App\Models\Addworking\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\User\User;
use App\Models\Everial\Mission\Referential;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class OfferTest extends TestCase
{
    use RefreshDatabase;

    protected $class = Offer::class;

    public function testGetAvailableReferentials()
    {
        $offer = factory(Offer::class)->create();
        $referentials = factory(Referential::class, 5)->create();
        $referentialArray = $offer->getAvailableReferentials();

        $this->assertIsArray($referentialArray, 'This should be an array');

        $this->assertEquals(count($referentialArray), 5);
    }

    public function testEverialReferentialMissions()
    {
        $offer = factory(Offer::class)->create();
        $referentials = factory(Referential::class, 5)->create();
        $offer->everialReferentialMissions()->attach($referentials);
        $referentialCollection = $offer->everialReferentialMissions;

        $this->assertInstanceOf(Collection::class, $referentialCollection);
        $this->assertEquals(count($referentialCollection), 5);
    }

    public function testScopeFilterReferent()
    {
        $offer = factory(Offer::class)->create();
        $referent = factory(User::class)->create([
            'firstname' => 'john',
            'lastname' => 'smith'
        ]);
        $offer->referent()->associate($referent)->save();

        $this->assertEquals(
            1,
            Offer::filterReferent('joh')->count(),
            'We should find the offer by referent firstname'
        );

        $this->assertEquals(
            1,
            Offer::filterReferent('mit')->count(),
            'We should find the offer by referent lastname'
        );

        $this->assertEquals(
            0,
            Offer::filterReferent('foo')->count(),
            'We should find 0 offer by this search term'
        );
    }

    public function testScopeSearch()
    {
        $offer = tap(factory(Offer::class)->make(['label' => '4 palettes chartres']), function ($offer) {
            $customer = factory(Enterprise::class)->states('customer')->create(['name' => 'Foo Bar']);
            $referent = $referent = factory(User::class)->create(['firstname' => 'john','lastname' => 'smith']);
            $offer->customer()->associate($customer);
            $offer->referent()->associate($referent);
            $offer->save();
        });

        $this->assertEquals(
            1,
            Offer::search('char')->count(),
            'We should find the offer by label'
        );

        $this->assertEquals(
            1,
            Offer::search('foo')->count(),
            'We should find the offer by customer name'
        );

        $this->assertEquals(
            1,
            Offer::search('joh')->count(),
            'We should find the offer by referent firstname'
        );

        $this->assertEquals(
            1,
            Offer::search('smit')->count(),
            'We should find the offer by referent lastname'
        );

        $this->assertEquals(
            0,
            Offer::search('doe')->count(),
            'We should find 0 offer by this search term'
        );
    }
}
