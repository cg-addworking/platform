<?php

namespace Tests\Unit\App\Models\Addworking\Mission;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProposalTest extends TestCase
{
    use RefreshDatabase;

    public function testFile()
    {
        $proposal = factory(Proposal::class)->create();
        $proposal->file()->associate(factory(File::class)->create())->save();

        $this->assertCount(
            1,
            $proposal->file->get(),
            "Proposal should be bindable to file"
        );
    }

    public function testScopeFilterLabel()
    {
        $mission = factory(Proposal::class)->create(['label' => 'this is a proposal label']);

        $this->assertEquals(
            1,
            Proposal::filterLabel('this')->count(),
            'We should find the proposal by label'
        );

        $this->assertEquals(
            0,
            Proposal::filterLabel('foo')->count(),
            'We should find 0 propsal by this search term'
        );
    }

    public function testScopeFilterVendor()
    {
        $proposal = tap(factory(Proposal::class)->make(), function ($proposal) {
            $vendor = factory(Enterprise::class)->states('vendor')->create(['name' => 'ACME Corp']);
            $proposal->vendor()->associate($vendor);
            $proposal->save();
        });

        $this->assertEquals(
            1,
            Proposal::search('cor')->count(),
            'We should find the proposal by vendor name'
        );

        $this->assertEquals(
            0,
            Proposal::search('doe')->count(),
            'We should find 0 proposal by this search term'
        );
    }

    public function testScopeFilterCustomer()
    {
        $proposal = tap(factory(Proposal::class)->make(), function ($proposal) {
            $offer = tap(factory(Offer::class)->make(), function ($offer) {
                $customer = factory(Enterprise::class)->states('customer')->create(['name' => 'Foo Bar']);
                $offer->customer()->associate($customer);
                $offer->save();
            });
            $proposal->offer()->associate($offer);
            $proposal->save();
        });

        $this->assertEquals(
            1,
            Proposal::search('foo')->count(),
            'We should find the proposal by customer name'
        );

        $this->assertEquals(
            0,
            Proposal::search('doe')->count(),
            'We should find 0 proposal by this search term'
        );
    }

    public function testScopeSearch()
    {
        $proposal = tap(factory(Proposal::class)->make(['label' => '4 palettes chartres']), function ($proposal) {
            $offer = tap(factory(Offer::class)->make(['label' => '4 palettes chartres']), function ($offer) {
                $customer = factory(Enterprise::class)->states('customer')->create(['name' => 'Foo Bar']);
                $referent = $referent = factory(User::class)->create(['firstname' => 'john','lastname' => 'smith']);
                $offer->customer()->associate($customer);
                $offer->referent()->associate($referent);
                $offer->save();
            });
            $vendor = factory(Enterprise::class)->states('vendor')->create(['name' => 'Baz Qux']);
            $proposal->offer()->associate($offer);
            $proposal->vendor()->associate($vendor);
            $proposal->save();
        });

        $this->assertEquals(
            1,
            Proposal::search('char')->count(),
            'We should find the proposal by label'
        );

        $this->assertEquals(
            1,
            Proposal::search('foo')->count(),
            'We should find the proposal by customer name'
        );

        $this->assertEquals(
            1,
            Proposal::search('qux')->count(),
            'We should find the proposal by vendor name'
        );

        $this->assertEquals(
            1,
            Proposal::search('joh')->count(),
            'We should find the proposal by referent firstname'
        );

        $this->assertEquals(
            1,
            Proposal::search('smit')->count(),
            'We should find the proposal by referent lastname'
        );

        $this->assertEquals(
            0,
            Proposal::search('doe')->count(),
            'We should find 0 proposal by this search term'
        );
    }

    public function testIsExpired()
    {
        $proposal = factory(Proposal::class)->create(['valid_until' => date('Y-m-d', strtotime('+3 weeks'))]);

        $this->assertFalse($proposal->isExpired(), 'The proposal is not expired');

        $proposal->valid_until = date('Y-m-d', strtotime('-2 days'));

        $proposal->save();

        $this->assertTrue($proposal->isExpired(), 'The proposal has expired');
    }
}
