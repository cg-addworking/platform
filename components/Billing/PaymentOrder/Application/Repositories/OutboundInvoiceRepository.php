<?php
namespace Components\Billing\PaymentOrder\Application\Repositories;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Carbon\Carbon;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\OutboundInvoiceRepositoryInterface;

class OutboundInvoiceRepository implements OutboundInvoiceRepositoryInterface
{
    public function findByNumber(string $number)
    {
        return OutboundInvoice::where('number', $number)->first();
    }

    public function hasStatus(OutboundInvoiceInterface $invoice, string $status): bool
    {
        return $invoice->getStatus() == $status;
    }

    public function find(string $id)
    {
        return OutboundInvoice::where('id', $id)->first();
    }

    public function getOutboundInvoicesToPayOfCustomer(Enterprise $enterprise)
    {
        return OutboundInvoice::whereHas('enterprise', function ($query) use ($enterprise) {
            $enterprises = app()->make(FamilyEnterpriseRepository::class)->getDescendants($enterprise, true);
            return $query->whereIn('id', $enterprises->pluck('id'));
        })->whereNotIn('status', [OutboundInvoice::STATUS_FULLY_PAID, 'paid'])
            ->where('created_at', '>', Carbon::today()->startOfMonth()->subMonths(3)->toDateString())
            ->orderBy('number', 'desc')
            ->cursor();
    }
}
