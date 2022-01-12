<?php

namespace Tests\Unit\App\Repositories\Addworking\Mission;

use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\PurchaseOrder;
use App\Repositories\Addworking\Mission\PurchaseOrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class PurchaseOrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testFind()
    {
        $repo = app(PurchaseOrderRepository::class);
        $order = factory(PurchaseOrder::class)->create();

        $this->assertTrue($repo->find($order)->is($order));
    }

    public function testList()
    {
        $repo = app(PurchaseOrderRepository::class);
        $orders = factory(PurchaseOrder::class, 3)->create();

        $this->assertEquals($repo->list()->count(), 3);
    }

    public function testUpdate()
    {
        $repo = app(PurchaseOrderRepository::class);
        $order = factory(PurchaseOrder::class)->create();

        $this->assertTrue($repo->update($order, ['status' => PurchaseOrder::STATUS_SENT]));
    }

    public function testDelete()
    {
        $repo = app(PurchaseOrderRepository::class);
        $order = factory(PurchaseOrder::class)->create();

        $this->assertTrue($repo->delete($order));
    }

    public function testSetStatusToSent()
    {
        $order = factory(PurchaseOrder::class)->states('draft')->create();

        $enterprise = $order->mission->customer;

        $mission = $order->mission;

        $requestParams = [
            'purchase_order' => [
                'status' => PurchaseOrder::STATUS_SENT
            ]
        ];

        $request = Request::create(
            "enterprise/{$enterprise->id}/mission/{$mission->id}/purchase_order/{$order->id}/send",
            'POST',
            $requestParams
        );

        $repo = app(PurchaseOrderRepository::class);

        $order = $repo->setStatus($order, $request);

        $this->assertEquals(PurchaseOrder::STATUS_SENT, $order->status);
    }
}
