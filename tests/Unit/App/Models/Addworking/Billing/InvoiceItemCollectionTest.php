<?php

namespace Tests\Unit\App\Models\Addworking\Billing;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use App\Models\Addworking\Billing\VatRate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceItemCollectionTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAmountBeforeTaxes()
    {
        $invoice = tap(factory(InboundInvoice::class)->create(), function ($invoice) {
            factory(InboundInvoiceItem::class, 5)->make(['quantity' => 2, 'unit_price' => 100])
                ->each(function ($item) use ($invoice) {
                    $item
                        ->invoice()->associate($invoice)
                        ->vatRate()->associate(factory(VatRate::class)->create(['value' => .1]))
                        ->save();
                });
        });

        $this->assertEquals(
            1000,
            $invoice->items->getAmountBeforeTaxes()
        );
    }

    public function testGetAmountOfTaxes()
    {
        $invoice = tap(factory(InboundInvoice::class)->create(), function ($invoice) {
            factory(InboundInvoiceItem::class, 5)->make(['quantity' => 2, 'unit_price' => 100])
                ->each(function ($item) use ($invoice) {
                    $item
                        ->invoice()->associate($invoice)
                        ->vatRate()->associate(factory(VatRate::class)->create(['value' => .1]))
                        ->save();
                });
        });

        $this->assertEquals(
            100,
            $invoice->items->getAmountOfTaxes()
        );
    }

    public function testGetAmountAllTaxesIncluded()
    {
        $invoice = tap(factory(InboundInvoice::class)->create(), function ($invoice) {
            factory(InboundInvoiceItem::class, 5)->make(['quantity' => 2, 'unit_price' => 100])
                ->each(function ($item) use ($invoice) {
                    $item
                        ->invoice()->associate($invoice)
                        ->vatRate()->associate(factory(VatRate::class)->create(['value' => .1]))
                        ->save();
                });
        });

        $this->assertEquals(
            1100,
            $invoice->items->getAmountAllTaxesIncluded()
        );
    }
}
