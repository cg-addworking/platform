@inject('contractModelPartRepository', 'Components\Contract\Model\Application\Repositories\ContractModelPartRepository')
@inject('contractModelRepository', 'Components\Contract\Model\Application\Repositories\ContractModelRepository')
@inject('contractModelVariableRepository', 'Components\Contract\Model\Application\Repositories\ContractModelVariableRepository')

@component('foundation::layout.app._actions', ['model' => $contract_model])
    @can('show', $contract_model)
        <a class="dropdown-item" href="{{ route('support.contract.model.show', $contract_model) }}">
            @icon('eye|mr:3|color:muted') {{ __('components.contract.model.application.views.contract_model._actions.consult') }}
        </a>
    @endcan
    @can('edit', $contract_model)
        <a class="dropdown-item" href="{{ route('support.contract.model.edit', $contract_model) }}">
            @icon('edit|mr:3|color:muted') {{ __('components.contract.model.application.views.contract_model._actions.edit') }}
        </a>
    @endcan

    @can('duplicate', $contract_model)
        <a class="dropdown-item" href="{{ route('support.contract.model.duplicate', $contract_model) }}">
            @icon('copy|mr:3|color:muted') {{ __('components.contract.model.application.views.contract_model._actions.duplicate') }}
        </a>
    @endcan

    @can('versionate', $contract_model)
        <a class="dropdown-item" href="{{ route('support.contract.model.versionate', $contract_model) }}">
            @icon('plus|mr:3|color:muted') {{ __('components.contract.model.application.views.contract_model._actions.versionate') }}
        </a>
    @endcan

    @can('index', [get_class($contractModelPartRepository->make())])
        <a class="dropdown-item" href="{{ route('support.contract.model.part.index', $contract_model) }}">
            @icon('file-contract|mr:3|color:muted') {{ __('components.contract.model.application.views.contract_model._actions.index_part', ['count' => $contract_model->getParts()->count()]) }}
        </a>
    @endcan

    @can('index', [get_class($contractModelPartRepository->make())])
        <a class="dropdown-item" href="{{ route('support.contract.model.variable.index', $contract_model) }}">
            @icon('asterisk|mr:3|color:muted') {{ __('components.contract.model.application.views.contract_model._actions.index_variables') }}
        </a>
    @endcan

    @can('delete', $contract_model)
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('components.contract.model.application.views.contract_model._actions.delete') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('support.contract.model.delete', $contract_model) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan

    @can('archive', $contract_model)
        <a class="dropdown-item"  onclick="confirm('Confirmer l\'archivage ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()" href="#">
            @icon('archive|mr:3|color:muted')
                {{ __('components.contract.model.application.views.contract_model._actions.archive') }}
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('support.contract.model.archive', $contract_model) }}" method="POST">
                @method('GET')
                @csrf
            </form>
        @endpush
    @endcan

@endcomponent
