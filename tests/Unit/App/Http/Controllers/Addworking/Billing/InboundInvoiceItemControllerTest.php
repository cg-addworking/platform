<?php

namespace Tests\Unit\App\Http\Controllers\Addworking\Billing;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Addworking\Billing\InboundInvoiceItemController;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Billing\VatRate;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InboundInvoiceItemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testConstruct()
    {
        $this->assertInstanceof(
            Controller::class,
            $this->app->make(InboundInvoiceItemController::class),
            "The controller should be a controller"
        );
    }

    public function testIndex()
    {
        $inbound_invoice = factory(InboundInvoice::class)->create();
        $enterprise = factory(Enterprise::class)->states('vendor')->create();
        $inbound_invoice->enterprise()->associate($enterprise)->save();

        $inbound_invoice_items = factory(InboundInvoiceItem::class, 5)->create()
            ->each(function ($inbound_invoice_item) use ($inbound_invoice) {
                $inbound_invoice_item->invoice()->associate($inbound_invoice);
                $inbound_invoice_item->save();
            });

        $user = factory(User::class)->state('support')->create();

        $response = $this->actingAs($user)
            ->get((new InboundInvoiceItem)->routes->index(@compact('enterprise', 'inbound_invoice')));

        $response->assertOk();
        $response->assertViewIs('addworking.billing.inbound_invoice_item.index');
        $response->assertViewHas('items');

        $items = $response->viewData('items');

        $this->assertEquals(5, $items->count(), "There should be 5 inbound_invoice_items in database");
    }

    public function testCreate()
    {
        $inbound_invoice = factory(InboundInvoice::class)->create();
        $enterprise = factory(Enterprise::class)->states('vendor')->create();
        $inbound_invoice->enterprise()->associate($enterprise)->save();

        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)
            ->get((new InboundInvoiceItem)->routes->create(@compact('enterprise', 'inbound_invoice')));

        $response->assertOk();
        $response->assertViewIs('addworking.billing.inbound_invoice_item.create');
    }

    public function testStore()
    {
        $inbound_invoice = factory(InboundInvoice::class)->create();
        $enterprise = factory(Enterprise::class)->states('vendor')->create();
        $inbound_invoice->enterprise()->associate($enterprise)->save();
        $vat_rate = factory(VatRate::class)->create();

        $data = [
            'label'       => 'Test 001',
            'quantity'    => 4,
            'unit_price'  => 2334.98,
            'vat_rate_id' => $vat_rate->id
        ];

        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)
            ->post((new InboundInvoiceItem)->routes->store(@compact('enterprise', 'inbound_invoice')), [
                'inbound_invoice_item' => $data
            ]);

        $this->assertDatabaseHas((new InboundInvoiceItem)->getTable(), ['label' => 'Test 001', 'quantity' => 4]);
    }

    public function testShow()
    {
        $inbound_invoice_item = factory(InboundInvoiceItem::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get($inbound_invoice_item->routes->show);

        $response->assertOk();
        $response->assertViewIs('addworking.billing.inbound_invoice_item.show');
    }

    public function testEdit()
    {
        $inbound_invoice_item = factory(InboundInvoiceItem::class)->create();
        $inbound_invoice_item->invoice->update(['status' => 'to_validate']);

        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get($inbound_invoice_item->routes->edit);

        $response->assertOk();
        $response->assertViewIs('addworking.billing.inbound_invoice_item.edit');
    }

    public function testUpdate()
    {
        $inbound_invoice = factory(InboundInvoice::class)->state('to_validate')->create();
        $enterprise = factory(Enterprise::class)->states('vendor')->create();
        $inbound_invoice->enterprise()->associate($enterprise)->save();

        $inbound_invoice_item = factory(InboundInvoiceItem::class)->create();
        $inbound_invoice_item->invoice()->associate($inbound_invoice)->save();

        $data = [
            'label'       => "Test",
            'quantity'    => "4",
            'unit_price'  => "100",
            'vat_rate_id' => $inbound_invoice_item->vatRate->id,
        ];

        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)
            ->put($inbound_invoice_item->routes->update(@compact('enterprise', 'inbound_invoice')), [
                'inbound_invoice_item' => $data,
            ]);

        $this->assertDatabaseHas((new InboundInvoiceItem)->getTable(), $data);
    }

    public function testDestroy()
    {
        $inbound_invoice_item = factory(InboundInvoiceItem::class)->create();
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->delete($inbound_invoice_item->routes->destroy);

        $this->assertDatabaseHas((new InboundInvoiceItem)->getTable(), [
            'label'      => $inbound_invoice_item->label,
        ]);
    }
}
