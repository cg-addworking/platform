@component('foundation::layout.app._actions', ['model' => $contract_model_document_type])
    @can('delete', $contract_model_document_type)
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('components.contract.model.application.views.contract_model_document_type._actions.delete') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('support.contract.model.party.document_type.delete', [$contract_model_party->getContractModel(), $contract_model_party, $contract_model_document_type]) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan
@endcomponent