<?php

namespace Tests\Unit\App\Models\Addworking\Mission;

use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\PurchaseOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseOrderTest extends TestCase
{
    use RefreshDatabase;

    public function testStatus()
    {
        $draftOrders = factory(PurchaseOrder::class, 5)->states('draft')->create();
        $sentOrders = factory(PurchaseOrder::class, 3)->states('sent')->create();

        $this->assertEquals(
            5,
            PurchaseOrder::whereStatus(PurchaseOrder::STATUS_DRAFT)->count(),
            "There should be only 5 orders with 'draft' status"
        );

        $this->assertEquals(
            3,
            PurchaseOrder::whereStatus(PurchaseOrder::STATUS_SENT)->count(),
            "There should be only 3 orders with 'sent' status"
        );
    }

    public function testScopeFilterMissionNumber()
    {
        $order = factory(PurchaseOrder::class, 9)->create();

        $this->assertEquals(
            1,
            PurchaseOrder::filterMissionNumber('8')->count(),
            'We should find the purchase order by mission number'
        );

        $this->assertEquals(
            0,
            PurchaseOrder::filterMissionNumber('11')->count(),
            'We should find 0 purchase order by this search term'
        );
    }

    public function testScopeFilterMissionLabel()
    {
        $order = tap(factory(PurchaseOrder::class)->make(), function ($order) {
            $mission = factory(Mission::class)->create(['label' => '4 palettes chartres']);
            $order->mission()->associate($mission)->save();
        });

        $this->assertEquals(
            1,
            PurchaseOrder::filterMissionLabel('char')->count(),
            'We should find the purchase order by mission label'
        );

        $this->assertEquals(
            0,
            PurchaseOrder::filterMissionLabel('foo')->count(),
            'We should find 0 purchase order by this search term'
        );
    }

    public function testScopeSearch()
    {
        $order = tap(factory(PurchaseOrder::class)->make(), function ($order) {
            $mission = factory(Mission::class)->create(['label' => '4 palettes chartres']);
            $order->mission()->associate($mission)->save();
        });

        $this->assertEquals(
            1,
            PurchaseOrder::search('2')->count(),
            'We should find the purchase order by mission number'
        );

        $this->assertEquals(
            1,
            PurchaseOrder::search('char')->count(),
            'We should find the purchase order by mission label'
        );

        $this->assertEquals(
            0,
            PurchaseOrder::search('foo')->count(),
            'We should find 0 purchase order by this search term'
        );
    }
}
