<tr>
    <td>@date($contract_model_document_type->getCreatedAt())</td>
    <td>{{ $contract_model_document_type->getDisplayName() ?? $contract_model_document_type->getDocumentType()->display_name ?? 'n/a' }}</td>
    <td class="text-center">{{ $contract_model_document_type->getValidatedBy() ?? "n/a" }}</td>
    <td class="text-center">
        @if($contract_model_document_type->getValidationRequired())
            <span class="badge badge-pill badge-success">{{ __('components.contract.model.application.views.contract_model_document_type._form.yes') }}</span>
        @else
            <span class="badge badge-pill badge-danger">{{ __('components.contract.model.application.views.contract_model_document_type._form.no') }}</span>
        @endif
    </td>
    <td class="text-right">
        @can('delete', $contract_model_document_type)
            <a role="button" class="btn btn-outline-danger btn-sm" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                @icon('trash-alt')
            </a>

            @push('forms')
                <form name="{{ $name }}" action="{{ route('support.contract.model.party.document_type.delete', [$contract_model_party->getContractModel(), $contract_model_party, $contract_model_document_type]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                </form>
            @endpush
        @else
            <a role="button" class="btn btn-outline-danger btn-sm" disabled>
                @icon('trash-alt|color:danger')
            </a>
        @endcan
    </td>
</tr>