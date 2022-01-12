<table class="table table-borderless">
    <tr style="font-size: 18px !important;">
        <td colspan="2" class="text-center bg-bleu-addworking text-white">
            @if ($outboundInvoice->getParent()->exists)
                {{ __('billing.outbound.application.views.file._header.credit_note_invoice') }} {{ $outboundInvoice->getFormattedNumber() }}
            @else
                {{ __('billing.outbound.application.views.file._header.invoice_number') }} {{ $outboundInvoice->getFormattedNumber() }}
            @endif
        </td>
    </tr>
</table>
