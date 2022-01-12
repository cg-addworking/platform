<?php

namespace Tests\Unit\App\Models\Addworking\Billing;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use App\Models\Addworking\Billing\InvoiceItemCollection;
use App\Models\Addworking\Billing\VatRate;
use Components\Infrastructure\Foundation\Application\Test\ModelTestCase;
use UnexpectedValueException;

class InboundInvoiceItemTest extends ModelTestCase
{
    protected $class = InboundInvoiceItem::class;

    public function testNewCollection()
    {
        $this->assertInstanceOf(
            InvoiceItemCollection::class,
            factory(InboundInvoiceItem::class)->create()->newCollection(),
        );

        $invoice = tap(factory(InboundInvoice::class)->create(), function ($invoice) {
            factory(InboundInvoiceItem::class, 5)->make()->each(function ($item) use ($invoice) {
                $item->invoice()->associate($invoice)->save();
            });
        });

        $this->assertInstanceOf(
            InvoiceItemCollection::class,
            $invoice->items
        );
    }

    public function testGetAmountBeforeTaxes()
    {
        $item = tap(factory(InboundInvoiceItem::class)->make(['quantity' => 2, 'unit_price' => 100]), function ($item) {
            $item->vatRate()->associate(
                factory(VatRate::class)->create(['value' => .1])
            );
        });

        $this->assertEquals(
            200,
            $item->getAmountBeforeTaxes()
        );
    }

    public function testGetAmountOfTaxes()
    {
        $item = tap(factory(InboundInvoiceItem::class)->make(['quantity' => 2, 'unit_price' => 100]), function ($item) {
            $item->vatRate()->associate(
                factory(VatRate::class)->create(['value' => .1])
            );
        });

        $this->assertEquals(
            20,
            $item->getAmountOfTaxes()
        );
    }

    public function testGetAmountAllTaxesIncluded()
    {
        $item = tap(factory(InboundInvoiceItem::class)->make(['quantity' => 2, 'unit_price' => 100]), function ($item) {
            $item->vatRate()->associate(
                factory(VatRate::class)->create(['value' => .1])
            );
        });

        $this->assertEquals(
            220,
            $item->getAmountAllTaxesIncluded()
        );
    }
}
