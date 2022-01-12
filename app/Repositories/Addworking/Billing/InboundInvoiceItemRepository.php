<?php

namespace App\Repositories\Addworking\Billing;

use App\Exceptions\InboundInvoiceItemAlreadyExistsException;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use App\Models\Addworking\Billing\InvoiceItemCollection;
use App\Models\Addworking\Billing\VatRate;
use App\Repositories\BaseRepository;
use Components\Infrastructure\DatabaseCommands\Helpers\ModelFinder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class InboundInvoiceItemRepository extends BaseRepository
{
    protected $model = InboundInvoiceItem::class;

    public function createFromRequest(Request $request, InboundInvoice $inbound_invoice): InboundInvoiceItem
    {
        return $this->updateFromRequest($request, $this->make()->invoice()->associate($inbound_invoice));
    }

    public function updateFromRequest(Request $request, InboundInvoiceItem $inbound_invoice_item): InboundInvoiceItem
    {
        return tap($inbound_invoice_item, function ($item) use ($request) {
            $item->fill($request->input('inbound_invoice_item'))
                ->vatRate()->associate($request->input('inbound_invoice_item.vat_rate_id'))
                ->save();
        });
    }

    public function createFromTrackingLines(Request $request, InboundInvoice $inbound_invoice): InvoiceItemCollection
    {
        foreach ($request->input('inbound_invoice.items') as $inbound_invoice_item) {
            if (isset($inbound_invoice_item['invoiceable_id'])) {
                $vat_rate = VatRate::find($inbound_invoice_item['vat_rate_id']);
                $model = App::make('laravel-models')->find($inbound_invoice_item['invoiceable_id']);

                if (!$this->checkIfCreatedAlready($inbound_invoice, $model)) {
                    tap($model, function ($invoiceable) use ($inbound_invoice, $vat_rate) {
                            $item = new InboundInvoiceItem;
                            $item->label      = $invoiceable->label;
                            $item->quantity   = $invoiceable->quantity;
                            $item->unit_price = $invoiceable->unit_price;

                            $item->vatRate()->associate($vat_rate->id);
                            $item->invoiceable()->associate($invoiceable);
                            $item->invoice()->associate($inbound_invoice->id);
                            $item->save();
                    });
                } else {
                    throw new InboundInvoiceItemAlreadyExistsException;
                }
            }
        }

        return $inbound_invoice->items;
    }

    public function checkIfCreatedAlready(InboundInvoice $inbound_invoice, $invoiceable): bool
    {
        return !InboundInvoiceItem::where('label', $invoiceable->label)
            ->where('quantity', !is_null($invoiceable->quantity) ? $invoiceable->quantity : 0)
            ->where('unit_price', !is_null($invoiceable->unit_price) ? $invoiceable->unit_price : 0)
            ->whereHas('invoice', function ($q) use ($inbound_invoice) {
                return $q->where('id', $inbound_invoice->id);
            })
            ->whereHas('invoiceable', function ($q) use ($invoiceable) {
                return $q->where('id', $invoiceable->id);
            })
            ->get()
            ->isEmpty();
    }
}
