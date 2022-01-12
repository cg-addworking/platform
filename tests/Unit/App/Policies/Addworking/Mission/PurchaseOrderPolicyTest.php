<?php

namespace Tests\Unit\App\Policies\Addworking\Mission;

use App\Models\Addworking\Mission\PurchaseOrder;
use App\Models\Addworking\User\User;
use App\Policies\Addworking\Mission\PurchaseOrderPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseOrderPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testDelete()
    {
        $policy = $this->app->make(PurchaseOrderPolicy::class);

        $user = factory(User::class)->states('support')->create();

        $order = factory(PurchaseOrder::class)->states('draft')->create();

        $this->assertTrue(
            $policy->delete($user, $order),
            'Support user should be able to delete purchase order when its status = "draft"'
        );

        $order = factory(PurchaseOrder::class)->states('sent')->create();

        $this->assertFalse(
            $policy->delete($user, $order),
            'Support user can not delete purchase order when its status = "sent"'
        );
    }

    public function testSend()
    {
        $policy = $this->app->make(PurchaseOrderPolicy::class);

        $user = factory(User::class)->states('support')->create();

        $order = factory(PurchaseOrder::class)->states('draft')->create();

        $this->assertTrue(
            $policy->send($user, $order),
            'Support user should be able to send purchase order'
        );
    }
}
