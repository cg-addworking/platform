<table class="table table-borderless table-sm">
    <tbody>
    <tr>
        <td colspan="2">
            @if($outboundInvoice->getReverseChargeVat())
                <p>
                   {{ __('billing.outbound.application.views.file._legal_notice.line_1') }}
                </p>
            @endif
            @if($outboundInvoice->getDaillyAssignment())
                <p class="font-weight-bold text-danger">
                    {{ __('billing.outbound.application.views.file._legal_notice.line_2') }}<br>
                    {{ __('billing.outbound.application.views.file._legal_notice.line_3') }}<br>
                    {{ __('billing.outbound.application.views.file._legal_notice.line_4') }}<br>
                    {{ __('billing.outbound.application.views.file._legal_notice.line_5') }}<br>
                    {{ __('billing.outbound.application.views.file._legal_notice.line_6') }}
                </p>
            @endif
            @if(! is_null($outboundInvoice->getLegalNotice()))
                <p>
                    {{ $outboundInvoice->getLegalNotice() }}
                </p>
            @endif
        </td>
    </tr>
    </tbody>
</table>