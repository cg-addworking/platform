<?php

namespace Tests\Unit\App\Http\Controllers\Addworking\Mission;

use App\Models\Addworking\Mission\PurchaseOrder;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSend()
    {
        $user = factory(User::class)->states('support')->create();

        $order = factory(PurchaseOrder::class)->states('draft')->create();

        $enterprise = $order->mission->customer;

        $mission = $order->mission;

        $requestParams = [
            'purchase_order' => [
                'status' => 'draft',
            ]
        ];

        $this
            ->actingAs($user)
            ->post(
                "enterprise/{$enterprise->id}/mission/{$mission->id}/purchase_order/{$order->id}/send",
                $requestParams
            )
            ->assertRedirect($order->routes->show);
    }
}
