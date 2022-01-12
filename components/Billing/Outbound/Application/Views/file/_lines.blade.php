<table class="table table-hover table-sm p-1">
    <thead>
    <tr class="table-active" style="font-size: 10px !important;">
        <th scope="col">{{ __('billing.outbound.application.views.file._lines.subcontracted_code') }}</th>
        <th scope="col">{{ __('billing.outbound.application.views.file._lines.name') }}</th>
        <th scope="col">{{ __('billing.outbound.application.views.file._lines.period') }}</th>
        <th scope="col" class="text-right">{{ __('billing.outbound.application.views.file._lines.amount_ht') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lines as $item)
        <tr>
            <td>{{ $item['vendor_code'] }}</td>
            <td>{{ $item['vendor_name'] }}</td>
            <td>{{ $item['period'] }}</td>
            <td class="text-right">@money($item['amount'])</td>
        </tr>
    @endforeach

    @foreach($linesAddhoc as $item)
        <tr>
            <td>{{ $item['vendor_code'] }}</td>
            <td>{{ $item['vendor_name'] }}</td>
            <td>{{ $item['period'] }}</td>
            <td class="text-right">@money($item['amount'])</td>
        </tr>
    @endforeach

    @if(count($lines) == 0 && $feeRepository->getManagementFeesOfOutboundInvoiceBeforeTaxes($outboundInvoice) > 0)
        <tr>
            <td>n/a</td>
            <td>{{ __('billing.outbound.application.views.file._lines.line_1') }}</td>
            <td>{{ $outboundInvoice->getMonth() }}</td>
            <td class="text-right">@money($feeRepository->getManagementFeesOfOutboundInvoiceBeforeTaxes($outboundInvoice))</td>
        </tr>
    @endif

    @if($outboundInvoiceFileRepository->getTotalOfSubscriptionFeesBeforeTaxes($outboundInvoice) > 0)
        <tr>
            <td>n/a</td>
            <td>{{ __('billing.outbound.application.views.file._lines.line_2') }}</td>
            <td>{{ $outboundInvoice->getMonth() }}</td>
            <td class="text-right">@money($outboundInvoiceFileRepository->getTotalOfSubscriptionFeesBeforeTaxes($outboundInvoice))</td>
        </tr>
    @endif

    @if ($outboundInvoiceFileRepository->getTotalOfFixedFeesBeforeTaxes($outboundInvoice) > 0)
        <tr>
            <td>n/a</td>
            <td>{{ __('billing.outbound.application.views.file._lines.line_3') }} {{ $enterpriseRepository->getActiveVendors($outboundInvoice->getEnterprise(), $outboundInvoice->getMonth())->count() }} {{ __('billing.outbound.application.views.file._lines.line_4') }}</td>
            <td>{{ $outboundInvoice->getMonth() }}</td>
            <td class="text-right">@money($outboundInvoiceFileRepository->getTotalOfFixedFeesBeforeTaxes($outboundInvoice))</td>
        </tr>
    @endif

    @if ($outboundInvoiceFileRepository->getTotalOfDiscountFeesBeforeTaxes($outboundInvoice) < 0)
        <tr>
            <td>n/a</td>
            <td>{{ __('billing.outbound.application.views.file._lines.line_5') }}</td>
            <td>{{ $outboundInvoice->getMonth() }}</td>
            <td class="text-right">@money($outboundInvoiceFileRepository->getTotalOfDiscountFeesBeforeTaxes($outboundInvoice))</td>
        </tr>
    @endif
    </tbody>
</table>