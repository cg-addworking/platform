<table class="table table-borderless">
    <tr>
        <td>
            {{ __('billing.outbound.application.views.file._enterprises.of') }}<br>
            <span class="font-weight-bold text-bleu-addworking" style="font-size: 14px !important;">{{ __('billing.outbound.application.views.file._enterprises.addworking') }}</span><br>
            {{ __('billing.outbound.application.views.file._enterprises.line_1') }}<br>
            {{ __('billing.outbound.application.views.file._enterprises.line_2') }}<br>
            {{ __('billing.outbound.application.views.file._enterprises.france') }}<br>
            {{ __('billing.outbound.application.views.file._enterprises.line_3') }}<br>{{ __('billing.outbound.application.views.file._enterprises.line_4') }}
        </td>
        <td>
            A:<br>
            <span class="font-weight-bold text-bleu-addworking" style="font-size: 14px !important;">{{ $outboundInvoice->getEnterprise()->name }}</span><br>
            {{ strtoupper($address->address) }}<br>
            @if(! is_null($address->additionnal_address)) {{ strtoupper($address->additionnal_address) }}<br> @endif
            {{ strtoupper($address->zipcode) }} {{ strtoupper($address->town) }}<br>
            {{ __('billing.outbound.application.views.file._enterprises.france') }}
        </td>
    </tr>
    <tr>
        <td class="table-active">
            <span class="font-weight-bold">{{ __('billing.outbound.application.views.file._enterprises.invoice_number') }}</span> {{ $outboundInvoice->getFormattedNumber() }}<br>
            @if ($outboundInvoice->getParent()->exists)
                <span class="font-weight-bold">{{ __('billing.outbound.application.views.file._enterprises.parent_invoice_number') }}</span> {{ $outboundInvoice->getParent()->getFormattedNumber() }}<br>
            @endif
            <span class="font-weight-bold">{{ __('billing.outbound.application.views.file._enterprises.contract_number') }}</span> #<br>
            <span class="font-weight-bold">{{ __('billing.outbound.application.views.file._enterprises.date') }}</span> {{ $outboundInvoice->getInvoicedAt()->format('d/m/Y') }}
            <br>
        </td>
        @if($outboundInvoice->getDaillyAssignment())
            <td class="text-center">
                <span class="font-weight-bold text-danger">
                    {{ __('billing.outbound.application.views.file._enterprises.line_5') }}<br>
                    {{ __('billing.outbound.application.views.file._enterprises.line_6') }}
                </span>
            </td>
        @endif
    </tr>
</table>