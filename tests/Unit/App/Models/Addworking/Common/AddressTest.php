<?php

namespace Tests\Unit\App\Models\Addworking\Common;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    // ------------------------------------------------------------------------
    // Class API
    // ------------------------------------------------------------------------

    public function testToString()
    {
        $address = factory(Address::class)->create();

        $this->assertEquals(
            $address->oneline(),
            $address->__toString(),
            "Address toString should be identical to oneLine"
        );
    }

    public function testToHtml()
    {
        $address = factory(Address::class)->create();

        $this->assertNotEmpty(
            $address->toHtml(),
            "Address should be convertible to HTML"
        );
    }

    public function testEnterprises()
    {
        $address = factory(Address::class)->create();
        $address->enterprises()->attach(factory(Enterprise::class)->create());
        $address->enterprises()->attach(factory(Enterprise::class)->create());
        $address->enterprises()->attach(factory(Enterprise::class)->create());

        $this->assertCount(
            3,
            $address->enterprises,
            "Address should be bindable to enterprises"
        );
    }

    public function testSites()
    {
        $address = factory(Address::class)->create();
        $address->sites()->attach(factory(Site::class)->create());
        $address->sites()->attach(factory(Site::class)->create());
        $address->sites()->attach(factory(Site::class)->create());

        $this->assertCount(
            3,
            $address->sites,
            "Address should be bindable to sites"
        );
    }

    public function testGetTownZipcodeAttribute()
    {
        $address = factory(Address::class)->create(['town' => "FOO", 'zipcode' => "12345"]);

        $this->assertEquals(
            "FOO (12345)",
            $address->town_zipcode,
            "One should be able to strigify the town and zipcode only"
        );
    }

    public function testGetOneLineAttribute()
    {
        $address = factory(Address::class)->create();

        $this->assertEquals(
            $address->oneLine(),
            $address->one_line,
            "Address one_line pseudo attribute should be the same as oneLine"
        );
    }

    public function testSetTownAttribute()
    {
        $address = factory(Address::class)->create();
        $address->town = "Foo Bar";

        $this->assertEquals(
            "FOO BAR",
            $address->town,
            "Town should be uppercased"
        );
    }

    public function testOneLine()
    {
        $address = new Address([
            'address'             => "12 rue des pénis",
            'additionnal_address' => "bien au fond à gauche",
            'zipcode'             => "69420",
            'town'                => "Poundtown",
            'country'             => "FR",
        ]);

        $this->assertEquals(
            "12 rue des pénis - bien au fond à gauche, 69420 POUNDTOWN",
            $address->oneLine(),
            "Address should be viewable on a single line of text"
        );
    }

    public function testGetUuidNode()
    {
        $address = new Address([
            'address'             => "A",
            'additionnal_address' => "B",
            'zipcode'             => "C",
            'town'                => "D",
            'country'             => "E",
        ]);

        $this->assertEquals(
            "A B C D E",
            $address->getUuidNode(),
            "Address UUID node part should be composed of 5 elements"
        );
    }

    public function testFirstOrCreate()
    {
        $address = Address::create($attributes = [
            'address'             => "12 rue des pénis",
            'additionnal_address' => "bien au fond à gauche",
            'zipcode'             => "69420",
            'town'                => "POUNDTOWN",
            'country'             => "FR",
        ]);

        $attributes['town'] = strtolower($attributes['town']);

        $this->assertTrue(
            Address::firstOrCreate($attributes)->is($address),
            "Address::firstOrCreate should be case insensitive on the town"
        );
    }
}
