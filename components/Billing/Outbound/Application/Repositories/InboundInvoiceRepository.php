<?php
namespace Components\Billing\Outbound\Application\Repositories;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Repositories\InboundInvoiceRepositoryInterface;

class InboundInvoiceRepository implements InboundInvoiceRepositoryInterface
{
    public function find(string $id)
    {
        return InboundInvoice::where('id', $id)->first();
    }

    public function findByNumber(string $number)
    {
        return InboundInvoice::where('number', $number)->first();
    }

    public function findBy(string $siret, string $number, string $month)
    {
        return InboundInvoice::where('number', $number)
            ->where('month', $month)
            ->whereHas('enterprise', function ($query) use ($siret) {
                $query->where('identification_number', $siret);
            })->first();
    }

    public function make()
    {
        return new InboundInvoice;
    }

    public function hasStatus(InboundInvoice $invoice, string $status): bool
    {
        return $invoice->status == $status;
    }

    public function hasItems(InboundInvoice $invoice): bool
    {
        return $invoice->items()->count() > 0;
    }

    public function getInboundInvoicesToAssociate(Enterprise $customer, OutboundInvoiceInterface $outboundInvoice)
    {
        $deadlines = $this->getDeadlinesGreaterThanOrEqualTo($outboundInvoice->getDeadline()->value);

        return InboundInvoice::where('month', $outboundInvoice->getMonth())
            ->doesntHave('items.outboundInvoiceItem')
            ->whereHas('customer', function ($query) use ($customer) {
                return $query->where('id', $customer->id);
            })->whereHas('deadline', function ($query) use ($deadlines) {
                return $query->whereIn('id', $deadlines);
            })->get()->sortBy('enterprise.name');
    }

    public function getInboundInvoicesToDissociate(Enterprise $customer, OutboundInvoiceInterface $outboundInvoice)
    {
        $deadlines = $this->getDeadlinesGreaterThanOrEqualTo($outboundInvoice->getDeadline()->value);

        return InboundInvoice::where('month', $outboundInvoice->getMonth())
            ->whereHas('items.outboundInvoiceItem.outboundInvoice', function ($query) use ($outboundInvoice) {
                return $query->where('id', $outboundInvoice->getId());
            })->whereHas('customer', function ($query) use ($customer) {
                return $query->where('id', $customer->id);
            })->whereHas('deadline', function ($query) use ($deadlines) {
                return $query->whereIn('id', $deadlines);
            })->get()->sortBy('enterprise.name');
    }

    private function getDeadlinesGreaterThanOrEqualTo($value)
    {
        return DeadlineType::where('value', '>=', $value)->pluck('id');
    }
}
