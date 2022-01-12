<?php

namespace Tests\Unit\App\Policies\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Policies\Addworking\Enterprise\IbanPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IbanPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $policy = $this->app->make(IbanPolicy::class);

        $customer = factory(Enterprise::class)->states('customer')->create();
        $customerUser = factory(User::class)->create();
        $customer->users()->attach($customerUser, ['is_admin' => true]);

        $this->assertFalse(
            $policy->create($customerUser),
            'Customer should not be able to create iban '
        );

        $policy = $this->app->make(IbanPolicy::class);

        $vendor = factory(Enterprise::class)->states('vendor')->create();
        $vendorUser = factory(User::class)->create();
        $vendor->users()->attach($vendorUser, ['is_admin' => true]);

        $this->assertTrue(
            $policy->create($vendorUser),
            'Vendor should be able to create iban '
        );
    }
}
