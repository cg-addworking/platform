<?php

namespace Components\Billing\Outbound\Application\Models\Concerns;

use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Illuminate\Support\Facades\DB;

trait FeeScopes
{
    public function scopeOfOutboundInvoice($query, OutboundInvoice $outboundInvoice)
    {
        return $query->whereHas('outboundInvoice', function ($query) use ($outboundInvoice) {
            $query->where('id', $outboundInvoice->id);
        });
    }

    public function scopeSearch($query, string $search)
    {
        //
    }
}
