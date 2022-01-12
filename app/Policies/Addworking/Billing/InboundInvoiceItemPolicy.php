<?php

namespace App\Policies\Addworking\Billing;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\User\User;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class InboundInvoiceItemPolicy
{
    use HandlesAuthorization;

    public function index(User $user, InboundInvoice $inbound_invoice)
    {
        return $user->isSupport()
            || ($user->enterprise->isCustomer()
                && $user->enterprise->isCustomerOf($inbound_invoice->enterprise)
                && $inbound_invoice->customer->is($user->enterprise))
                && ! $inbound_invoice->customer->isBusinessPlus();
    }

    public function show(User $user, InboundInvoiceItem $inbound_invoice_item)
    {
        return $this->index($user, $inbound_invoice_item->invoice);
    }

    public function create(User $user, InboundInvoice $inbound_invoice)
    {
        return $user->isSupport();
    }

    public function edit(User $user, InboundInvoiceItem $inbound_invoice_item)
    {
        return $user->isSupport()
            && ! in_array(
                $inbound_invoice_item->invoice->status,
                [InboundInvoice::STATUS_VALIDATED, InboundInvoice::STATUS_PAID]
            )
            && ! isset($inbound_invoice_item->invoiceable);
    }

    public function destroy(User $user, InboundInvoiceItem $inbound_invoice_item)
    {
        return $user->isSupport()
            && ! in_array(
                $inbound_invoice_item->invoice->status,
                [InboundInvoice::STATUS_VALIDATED, InboundInvoice::STATUS_PAID]
            );
    }
}
