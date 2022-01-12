@inject('documentTypeRejectReasonRepository', 'Components\Enterprise\Document\Application\Repositories\DocumentTypeRejectReasonRepository')
<tr>
    <td>{{ $document_type_reject_reason->getNumber() }}</td>
    <td>{{ $document_type_reject_reason->getDisplayName() }}</td>
    <td>
        @if(strlen($document_type_reject_reason->getMessage()) > 50)
            {{ substr($document_type_reject_reason->getMessage(), 0, 50) }} ...
            <a href="#" tabindex="0" data-container="body" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="{{ $document_type_reject_reason->getMessage() }}">Voir plus</a>
        @else
            {{ $document_type_reject_reason->getMessage() }}
        @endif
    </td>
    <td>@bool($documentTypeRejectReasonRepository->isUniversal($document_type_reject_reason))</td>
    <td class="text-right">
        @include('document::document_type_reject_reason._actions')
    </td>
</tr>