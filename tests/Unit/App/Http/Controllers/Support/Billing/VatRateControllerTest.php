<?php

namespace Tests\Unit\App\Http\Controllers\Support\Billing;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Support\Billing\VatRateController;
use App\Models\Addworking\User\User;
use App\Models\Addworking\Billing\VatRate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VatRateControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testConstruct()
    {
        $this->assertInstanceof(
            Controller::class,
            $this->app->make(VatRateController::class),
            "The controller should be a controller"
        );
    }

    public function testIndex()
    {
        $vat_rates = factory(VatRate::class, 5)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get((new VatRate)->routes->index);

        $response->assertOk();
        $response->assertViewIs('support.billing.vat_rate.index');
        $response->assertViewHas('items');

        $items = $response->viewData('items');

        $this->assertEquals(5, $items->total(), "There should be 5 vat_rates in database");
    }

    public function testCreate()
    {
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get((new VatRate)->routes->create);

        $response->assertOk();
        $response->assertViewIs('support.billing.vat_rate.create');
    }

    public function testStore()
    {
        $data = $request = factory(VatRate::class)->make()->toArray();
        $data['value'] = $request['value'] / 100;
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->post((new VatRate)->routes->store, ['vat_rate' => $request]);

        $this->assertDatabaseHas((new VatRate)->getTable(), $data);
    }

    public function testShow()
    {
        $vat_rate = factory(VatRate::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get($vat_rate->routes->show);

        $response->assertOk();
        $response->assertViewIs('support.billing.vat_rate.show');
    }

    public function testEdit()
    {
        $vat_rate = factory(VatRate::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get($vat_rate->routes->edit);

        $response->assertOk();
        $response->assertViewIs('support.billing.vat_rate.edit');
    }

    public function testUpdate()
    {
        $data = $request = factory(VatRate::class)->make()->toArray();
        $data['value'] = $request['value'] / 100;

        $vat_rate = factory(VatRate::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->put($vat_rate->routes->update, ['vat_rate' => $request]);

        $this->assertDatabaseHas((new VatRate)->getTable(), $data);
    }

    public function testDestroy()
    {
        $vat_rate = factory(VatRate::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->delete($vat_rate->routes->destroy);

        $this->assertDatabaseMissing((new VatRate)->getTable(), [
            'deleted_at' => $vat_rate->deleted_at,
        ]);
    }
}
