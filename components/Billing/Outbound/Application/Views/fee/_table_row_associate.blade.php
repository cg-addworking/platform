<tr>
    <td class="text-center"><input type="checkbox" name="fee[id][]" value="{{ $fee->id }}"></td>
    <td> {{ $fee->getNumber() }} </td>
    <td> {{ $fee->getLabel() }} </td>
    <td> @include('outbound_invoice::fee._type') </td>
    <td> {{ $fee->getVendor()->name ?? "n/a" }} </td>
    <td class="text-right"> @if($fee->getOutboundInvoiceItem()) @money($fee->getOutboundInvoiceItem()->getAmountBeforeTaxes()) @else n/a @endif</td>
    <td class="text-right"> @money($fee->getAmountBeforeTaxes()) </td>
    <td class="text-center"> {{ $fee->getVatRate()->display_name }} </td>
    <td class="text-right">
        <a class="btn btn-sm btn-outline-danger" href="#" onclick="confirm('Confirmer ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('minus-square|mr-3') <span>{{ __('billing.outbound.application.views.fee._table_row_associate.cancel') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('addworking.billing.outbound.credit_note.associate_fees', [$enterprise, $outboundInvoice]) }}" method="POST">
                @csrf
                <input type="hidden" name="fee[id][]" value="{{ $fee->id }}">
            </form>
        @endpush
    </td>
</tr>