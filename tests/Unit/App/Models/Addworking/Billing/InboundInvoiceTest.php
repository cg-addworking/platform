<?php

namespace Tests\Unit\App\Models\Addworking\Billing;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\Test\ModelTestCase;
use App\Models\Addworking\Mission\MissionTrackingLine;

class InboundInvoiceTest extends ModelTestCase
{
    protected $class = InboundInvoice::class;

    public function testItems()
    {
        $invoice = tap(factory(InboundInvoice::class)->create(), function ($invoice) {
            factory(InboundInvoiceItem::class, 5)->make()->each(function ($item) use ($invoice) {
                $item->invoice()->associate($invoice)->save();
            });
        });

        $this->assertCount(
            5,
            $invoice->items,
            "There should be 5 items attached to this invoice"
        );
    }

    public function testFile()
    {
        $invoice = tap(factory(InboundInvoice::class)->make(), function ($invoice) {
            $invoice->file()->associate(
                factory(File::class)->create(),
            )->save();
        });

        $this->assertTrue(
            $invoice->file->exists,
            "There should be an existing file associated to this invoice"
        );
    }

    public function testScopeSearch()
    {
        $inbound = factory(InboundInvoice::class)->create([
            'number' => 1234,
        ]);
        $inbound->enterprise->update(['name' => "VENDOR"]);
        $inbound->customer->update(['name' => "CUSTOMER"]);

        $this->assertEquals(
            1,
            InboundInvoice::search(23)->count(),
            'We should find the inbound invoice by number'
        );

        $this->assertEquals(
            0,
            InboundInvoice::search('foo')->count(),
            'We should find 0 inbound invoice by this search term'
        );

        $this->assertEquals(
            1,
            InboundInvoice::search('NDO')->count(),
            'We should find the inbound invoice by enterprise name'
        );

        $this->assertEquals(
            1,
            InboundInvoice::search('UST')->count(),
            'We should find the inbound invoice by customer name'
        );
    }

    public function testHasMissiontTrackingLines()
    {
        $item = factory(InboundInvoiceItem::class)->create();

        $this->assertFalse(
            $item->invoice->hasMissiontTrackingLines(),
            'this inbound has no mission tracking lines'
        );

        $line = factory(MissionTrackingLine::class)->create();

        $item->invoiceable()->associate($line)->save();

        $this->assertInstanceOf(MissionTrackingLine::class, $item->invoiceable);

        //$item->refresh();

        $this->assertTrue(
            $item->refresh()->invoice->hasMissiontTrackingLines(),
            'this inbound has mission tracking lines'
        );
    }

    public function testIsMissionTrackingLinesValidatedByCustomer()
    {
        $item = factory(InboundInvoiceItem::class)->create();

        $this->assertFalse(
            $item->invoice->isMissionTrackingLinesValidatedByCustomer(),
            'this inbound has no mission tracking lines'
        );

        $line = factory(MissionTrackingLine::class)->create([
            'validation_customer' => MissionTrackingLine::STATUS_PENDING]);

        $item->invoiceable()->associate($line)->save();

        $this->assertFalse(
            $item->invoice->isMissionTrackingLinesValidatedByCustomer(),
            'this inbound has mission tracking lines which are not validated by customer'
        );

        $line->update(['validation_customer' => MissionTrackingLine::STATUS_VALIDATED]);

        //$item->refresh();

        $this->assertTrue(
            $item->refresh()->invoice->isMissionTrackingLinesValidatedByCustomer(),
            'this inbound has mission tracking lines which are validated by customer'
        );
    }
}
