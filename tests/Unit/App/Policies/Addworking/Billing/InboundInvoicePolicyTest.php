<?php

namespace Tests\Unit\App\Policies\Addworking\Billing;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\User\User;
use App\Policies\Addworking\Billing\InboundInvoicePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InboundInvoicePolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $policy = $this->app->make(InboundInvoicePolicy::class);

        $customer = tap(factory(Enterprise::class)->states('customer')->create(), function ($customer) {
            $customer->users()->attach(
                factory(User::class)->create(),
                ['is_admin' => true]
            );
        });

        $this->assertFalse(
            $policy->create($customer->users()->first(), $customer)->allowed(),
            'Customer should not be able to create inbound invoice'
        );

        $policy = $this->app->make(InboundInvoicePolicy::class);

        $vendor = factory(Enterprise::class)->states('vendor')->create();
        $vendorUser = factory(User::class)->create();
        $vendor->users()->attach($vendorUser, ['is_admin' => true]);

        $this->assertFalse(
            $policy->create($vendor->users()->first(), $vendor)->allowed(),
            'Vendor should not be able to create inbound invoice without customer and iban'
        );

        $policy = $this->app->make(InboundInvoicePolicy::class);

        $vendor = tap(factory(Enterprise::class)->states('vendor')->create(), function ($vendor) {
            $vendor->customers()->attach(
                factory(Enterprise::class)->states('customer')->create()
            );
            $vendor->users()->attach(
                factory(User::class)->create(),
                ['is_admin' => true]
            );
        });

        $this->assertFalse(
            $policy->create($vendor->users()->first(), $vendor)->allowed(),
            'Vendor should not be able to create inbound invoice without iban'
        );

        $policy = $this->app->make(InboundInvoicePolicy::class);

        $vendor = tap(factory(Enterprise::class)->states('vendor')->create(), function ($vendor) {
            $vendor->customers()->attach(
                factory(Enterprise::class)->states('customer')->create()
            );
            $vendor->users()->attach(
                factory(User::class)->create(),
                ['is_admin' => true]
            );

            $vendor->ibans()->save(
                factory(Iban::class)->create([
                    'status'           => Iban::STATUS_APPROVED,
                    'validation_token' => null,
                ])
            );
        });

        $this->assertTrue(
            $policy->create($vendor->users()->first(), $vendor)->allowed(),
            'Vendor should be able to create inbound invoice'
        );
    }

    public function testExport()
    {
        $policy = $this->app->make(InboundInvoicePolicy::class);

        $this->assertTrue(
            $policy->export(factory(User::class)->state('support')->create())->allowed(),
            'Support Addworking should be able to export a csv of inbound invoices'
        );
    }

    public function testViewReconciliationInfo()
    {
        $policy = $this->app->make(InboundInvoicePolicy::class);

        $inbound  = factory(InboundInvoice::class)->create();
        $vendor   = $inbound->enterprise;
        $customer = $inbound->customer;
        $customer->vendors()->attach($vendor);

        $support  = factory(User::class)->states('support')->create();

        $this->assertTrue(
            $policy->viewReconciliationInfo($support, $inbound)->allowed(),
            'Support should be able to see the reconciliation info'
        );

        $this->assertTrue(
            $policy->viewReconciliationInfo($customer->users()->first(), $inbound)->allowed(),
            'Customer of the inbound should be able to see the reconciliation info'
        );

        $this->assertTrue(
            $policy->viewReconciliationInfo($vendor->users()->first(), $inbound)->denied(),
            'Vendor of the inbound should not be able to see the reconciliation info'
        );
    }

    public function testUpdateComplianceStatus()
    {
        $policy = $this->app->make(InboundInvoicePolicy::class);

        $inbound  = factory(InboundInvoice::class)->create();
        $vendor   = $inbound->enterprise;
        $customer = $inbound->customer;
        $customer->vendors()->attach($vendor);
        $support  = factory(User::class)->states('support')->create();

        $this->assertTrue(
            $policy->updateComplianceStatus($vendor->users()->first(), $inbound)->denied(),
            'Vendor of the inbound should not be able to update compliance status'
        );

        $this->assertTrue(
            $policy->updateComplianceStatus($customer->users()->first(), $inbound)->denied(),
            'Vendor of the inbound should not be able to update compliance status'
        );

        $this->assertTrue(
            $policy->updateComplianceStatus($support, $inbound)->allowed(),
            'Support should be able to update compliance status'
        );
    }
}
