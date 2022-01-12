<span class="font-weight-bold">{{ __('billing.outbound.application.views.file._annex.annex_details') }}</span>

<table class="table table-striped table-sm mt-2">
    <thead style="font-size: 6px !important;">
        <tr>
            <th scope="col">{{ __('billing.outbound.application.views.file._annex.subcontracter_code') }}</th>
            <th scope="col">{{ __('billing.outbound.application.views.file._annex.name') }}</th>
            <th scope="col">{{ __('billing.outbound.application.views.file._annex.wording') }}</th>
            <th scope="col">{{ __('billing.outbound.application.views.file._annex.ref_mission') }}</th>
            <th scope="col">{{ __('billing.outbound.application.views.file._annex.mission_code') }}</th>
            <th scope="col">{{ __('billing.outbound.application.views.file._annex.code_analytic') }}</th>
            <th scope="col" class="text-right">{{ __('billing.outbound.application.views.file._annex.price_ht') }}</th>
            <th scope="col" class="text-right">{{ __('billing.outbound.application.views.file._annex.management_fees_ht') }}</th>
            <th scope="col" class="text-right">{{ __('billing.outbound.application.views.file._annex.total_ht') }}</th>
        </tr>
    </thead>
    <tbody style="font-size: 8px !important;">
        @foreach ($linesAnnex as $item)
            <tr>
                <td>
                    {{-- TODO : Change this with code vendor in has_partners pivot --}}
                    {{ $item->getVendor()->sogetrelData->navibat_id ?? 'n/a' }}
                </td>
                <td>{{ $item->getVendor()->name ?? 'n/a' }}</td>
                <td>{{ $item->getLabel() ?? "n/a" }}</td>
                <td>{{ $item->inboundInvoiceItem->invoiceable->missionTracking->mission->number ?? "n/a" }}</td>
                <td>{{ $item->inboundInvoiceItem->invoiceable->missionTracking->external_id ?? "n/a" }}</td>
                <td>#</td>
                <td class="text-right">@money($item->getAmountBeforeTaxes())</td>
                <td class="text-right">@money($feeRepository->getManagementFeesOfOutboundInvoiceItemBeforeTaxes($item, $outboundInvoice))</td>
                <td class="text-right last">@money($item->getAmountBeforeTaxes() + $feeRepository->getManagementFeesOfOutboundInvoiceItemBeforeTaxes($item, $outboundInvoice))</td>
            </tr>
        @endforeach
    </tbody>
</table>
