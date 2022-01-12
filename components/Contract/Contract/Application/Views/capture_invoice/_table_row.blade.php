@inject('captureInvoiceRepository', 'Components\Contract\Contract\Application\Repositories\CaptureInvoiceRepository')
<tr>
    <td>
        @can('edit', get_class($captureInvoiceRepository->make()))
            <a class="btn btn-sm btn-outline-warning" href="{{route('contract.capture_invoice.edit', [$contract, $captureInvoiceRepository->find($invoice['id'])])}}">
                @icon('edit')
            </a>
        @endcan

        @can('delete', get_class($captureInvoiceRepository->make()))
            <a class="btn btn-sm btn-outline-danger" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                @icon('trash-alt')
            </a>

            @push('forms')
                <form name="{{ $name }}" action="{{ route('contract.capture_invoice.delete', [$contract, $captureInvoiceRepository->find($invoice['id'])]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                </form>
            @endpush
        @endcan
    </td>
    <td>{{$invoice['number']}}</td>
    <td>@date($invoice['invoiced_at'])</td>
    <td>{{$invoice['amount_before_taxes']}}</td>
    <td>{{$invoice['amount_of_taxes']}}</td>
    <td>{{$invoice['deposit_guaranteed_holdback_number']}}</td>
    <td>{{$invoice['amount_guaranteed_holdback']}}</td>
    <td>{{$invoice['deposit_good_end_number']}}</td>
    <td>{{$invoice['amount_good_end']}}</td>
</tr>
