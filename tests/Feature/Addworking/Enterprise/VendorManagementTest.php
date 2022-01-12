<?php

namespace Tests\Feature\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class VendorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexView()
    {
        $user       = factory(User::class)->create();
        $addworking = factory(Enterprise::class)->states('addworking')->create();
        $customer   = factory(Enterprise::class)->states('customer')->create();
        $vendors    = factory(Enterprise::class, 5)->states('vendor')->create();

        $customer->vendors()->attach($vendors);
        $customer->users()->attach($user, ['is_admin' => true]);
        $user->setPrimaryEnterprise($customer);

        $legal_types = factory(DocumentType::class, 5)->states('legal')->create()
            ->each(function ($type) use ($addworking) {
                $type->enterprise()->associate($addworking)->save();
            });

        $business_types = factory(DocumentType::class, 5)->states('business')->create()
            ->each(function ($type) use ($customer) {
                $type->enterprise()->associate($customer)->save();
            });

        $types = (new Collection)->merge($legal_types)->merge($business_types);

        $vendors->each(function ($vendor) use ($types) {
            $types->each(function ($type) use ($vendor) {
                $document = factory(Document::class)->states('pending')->make();
                $document->documentType()->associate($type);
                $document->enterprise()->associate($vendor);
                $document->save();
            });
        });

        $this->assertCount(5, $customer->vendors);
        $this->assertCount(5, $addworking->documentTypes);
        $this->assertCount(5, $customer->documentTypes);
        $this->assertTrue($user->isAdminFor($customer));
        $this->assertTrue($user->enterprise->exists);

        $vendors->each(function ($vendor) use ($customer) {
            $this->assertCount(10, $vendor->documents);

            $vendor->documents->each(function ($doc) {
                $this->assertTrue($doc->isPending());
            });
        });

        $response = $this->actingAs($user)->get(route('addworking.enterprise.vendor.index', $customer));
        $response->assertSuccessful();
        $response->assertViewIs('addworking.enterprise.vendor.index');

        $vendors->each(function ($vendor) use ($response) {
            $response->assertSee($vendor->name);
        });
    }
}
