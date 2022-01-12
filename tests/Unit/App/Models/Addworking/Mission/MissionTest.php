<?php

namespace Tests\Unit\App\Models\Addworking\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Mission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Components\Infrastructure\Foundation\Application\Test\ModelTestCase;

class MissionTest extends ModelTestCase
{
    use RefreshDatabase;

    protected $class = Mission::class;

    public function testScopeFilterStartsAt()
    {
        factory(Mission::class, 5)->create(['starts_at' => date('Y-m-d', strtotime('-1 week'))]);
        factory(Mission::class, 7)->create(['starts_at' => date('Y-m-d', strtotime('-4 days'))]);

        $this->assertEquals(
            5,
            Mission::filterStartsAt(date('Y-m-d', strtotime('-1 week')))->count(),
            'Thes should be only 5 missions with the given starts_at date'
        );
    }

    public function testScopeFilterLabel()
    {
        $mission = factory(Mission::class)->create(['label' => 'this is a mission label']);

        $this->assertEquals(
            1,
            Mission::filterLabel('this')->count(),
            'We should find the mission by label'
        );

        $this->assertEquals(
            0,
            Mission::filterLabel('foo')->count(),
            'We should find 0 mission by this search term'
        );
    }

    public function testScopeSearch()
    {
        $mission = tap(factory(Mission::class)->make(['label' => 'this is a mission label']), function ($mission) {
            $vendor = factory(Enterprise::class)->states('vendor')->create(['name' => 'Foo Bar']);
            $customer = factory(Enterprise::class)->states('customer')->create(['name' => 'acme corp']);
            $mission->vendor()->associate($vendor);
            $mission->customer()->associate($customer);
            $mission->save();
        });

        $this->assertEquals(
            1,
            Mission::search('mission')->count(),
            'We should find the mission by label'
        );

        $this->assertEquals(
            1,
            Mission::search('foo')->count(),
            'We should find the mission by vendor'
        );

        $this->assertEquals(
            1,
            Mission::search('acme')->count(),
            'We should find the mission by customer'
        );

        $this->assertEquals(
            1,
            Mission::search('1')->count(),
            'We should find the mission by mission number'
        );

        $this->assertEquals(
            0,
            Mission::search('hakuna')->count(),
            'We should find 0 mission by this search term'
        );
    }

    public function testScopeOfReferent()
    {
        $customer = factory(Enterprise::class)->states('customer')->create();
        $vendor = factory(Enterprise::class)->states('vendor')->create();
        $customer->vendors()->attach($vendor);
        $member = $customer->users()->first();

        tap(factory(Mission::class)->make(), function ($mission) use ($customer, $vendor) {
            $mission->vendor()->associate($vendor);
            $mission->customer()->associate($customer);
            $mission->save();
        });

        $this->assertEquals(
            0,
            Mission::ofReferent($customer->id, $member->id)->count(),
            "There should be 0 missions for {$vendor->name} assigned to {$member->name}"
        );

        $member->referentVendors()
            ->wherePivot('customer_id', $customer->id)
            ->attach($vendor, ['customer_id' => $customer->id, 'created_by' => $member->id]);

        $this->assertEquals(
            1,
            Mission::ofReferent($customer->id, $member->id)->count(),
            "There should be 1 mission for {$vendor->name} assigned to {$member->name}"
        );
    }
}
