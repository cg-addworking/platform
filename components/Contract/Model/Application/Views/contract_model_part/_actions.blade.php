@component('foundation::layout.app._actions', ['model' => $contract_model_part])

    @can('edit', $contract_model_part)
        <a class="dropdown-item" href="{{ route('support.contract.model.part.edit', [$contract_model, $contract_model_part]) }}">
            @icon('edit|color:muted|mr:3') {{ __('everial.mission.referential._actions.edit') }}
        </a>
    @endcan

    @can('preview', $contract_model_part)
        <a class="dropdown-item" target="_blank" href="{{ route('support.contract.model.part.preview', [$contract_model, $contract_model_part]) }}">
            @icon('file-export|mr:3|color:muted') {{ __('components.contract.model.application.views.contract_model_part._actions.preview') }}
        </a>
    @endcan

    @can('delete', $contract_model_part)
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('components.contract.model.application.views.contract_model_part._actions.delete') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('support.contract.model.part.delete', [$contract_model, $contract_model_part]) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan

@endcomponent
