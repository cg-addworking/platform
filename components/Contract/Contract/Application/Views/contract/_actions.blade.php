@inject('contractPartyRepository', 'Components\Contract\Contract\Application\Repositories\ContractPartyRepository')
@inject('contractPartRepository', 'Components\Contract\Contract\Application\Repositories\ContractPartRepository')
@inject('contractVariableRepository', 'Components\Contract\Contract\Application\Repositories\ContractVariableRepository')
@inject('contractRepository', 'Components\Contract\Contract\Application\Repositories\ContractRepository')

@can('show', $contract)
    <a class="dropdown-item" href="{{ route('contract.show', $contract) }}">
        @icon('eye|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract._actions.show') }}
    </a>
@endcan

@can('create', [get_class($contractPartyRepository->make([])), $contract])
    <a class="dropdown-item" href="{{ route('contract.party.create', $contract) }}">
        @icon('edit|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract._actions.edit_contract_party') }}
    </a>
@endcan

@can('index', [get_class($contractVariableRepository->make()), $contract])
    <a class="dropdown-item" href="{{ route('contract.variable.index', $contract) }}">
        @icon('edit|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract._actions.variable_list') }}
    </a>
@endcan

@can('linkContractToMission', $contract)
    <a class="dropdown-item" href="{{ route('contract_mission.create', ['contract' => $contract->getId()]) }}">
        @icon('link|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract._actions.link_mission') }}
    </a>
@endcan

@can('edit', $contract)
    <a class="dropdown-item" href="{{ route('contract.edit', $contract) }}">
        @icon('edit|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract._actions.edit') }}
    </a>
@endcan

@can('callBackContract', $contract)
    <a class="dropdown-item" href="{{ route('contract.call_back', $contract) }}">
        @icon('undo|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract._actions.call_back') }}
    </a>
@endcan

@can('editValidators', [get_class($contractPartyRepository->make()), $contract])
    <a class="dropdown-item" href="{{ route('contract.party.edit_validators', $contract) }}">
        @icon('edit|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract._actions.edit_validators')}}
    </a>
@endcan

@can('cancel', $contract)
    <a class="dropdown-item" href="{{ route('contract.cancel', $contract) }}">
        @icon('window-close|mr:3|color:warning') <span class="text-warning">{{ __('components.contract.contract.application.views.contract._actions.cancel') }}</span>
    </a>
@endcan

@can('deactivate', $contract)
    <a class="dropdown-item" href="{{ route('contract.deactivate', $contract) }}">
        @icon('ban|mr:3|color:warning') <span class="text-warning">{{ __('components.contract.contract.application.views.contract._actions.deactivate') }}</span>
    </a>
@endcan

@can('uploadSignedContract', $contract)
    <a class="dropdown-item" href="{{ route('contract.upload_signed_contract', $contract) }}">
        @icon('edit|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract._actions.upload_signed_contract') }}
    </a>
@endcan

@can('download', $contract)
    <a class="dropdown-item" href="{{ route('contract.download', $contract)}}">
        @icon('download|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract._actions.download') }}
    </a>

    @if($contractRepository->getContractModelDocumentTypeOfContract($contract)->count())
        <a class="dropdown-item" href="{{ route('contract.download_documents', $contract)}}">
            @icon('download|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract._actions.download_documents') }}
        </a>
    @endif
@endcan

@can('downloadProofOfSignature', $contract)
    <a class="dropdown-item" href="{{ route('contract.download_proof_of_signature', $contract)}}">
        @icon('download|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract._actions.download_proof_of_signature') }}
    </a>
@endcan

@can('archive', $contract)
    <a class="dropdown-item"  onclick="confirm('Confirmer l\'archivage ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()" href="#">
        @icon('archive|mr:3|color:muted')
            {{ __('components.contract.contract.application.views.contract._actions.archive') }}
    </a>

    @push('forms')
        <form name="{{ $name }}" action="{{ route('contract.archive', $contract) }}" method="POST">
            @method('GET')
            @csrf
        </form>
    @endpush
@endcan

@can('unarchive', $contract)
    <a class="dropdown-item"  onclick="confirm('Confirmer le désarchivage ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()" href="#">
        @icon('archive|mr:3|color:muted')
            {{ __('components.contract.contract.application.views.contract._actions.unarchive') }}
    </a>

    @push('forms')
        <form name="{{ $name }}" action="{{ route('contract.unarchive', $contract) }}" method="POST">
            @method('GET')
            @csrf
        </form>
    @endpush
@endcan

@can('updateContractFromYousignData', $contract)
    <a class="dropdown-item" href="{{ route('support.contract.update.from_yousign', $contract)}}">
        @icon('download|mr:3|color:muted') {{ __('components.contract.contract.application.views.contract._actions.update_contract_from_yousign_data') }}
    </a>
@endcan

@can('delete', $contract)
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
        @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('components.contract.contract.application.views.contract._actions.delete') }}</span>
    </a>

    <form name="{{ $name }}" action="{{ route('contract.delete', $contract) }}" method="POST">
        @method('DELETE')
        @csrf
    </form>
@endcan
