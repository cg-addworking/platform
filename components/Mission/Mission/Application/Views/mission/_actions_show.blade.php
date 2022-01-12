@inject('contractRepository', 'Components\Contract\Contract\Application\Repositories\ContractRepository')

@component('foundation::layout.app._actions')
    @can('edit', $mission)
        <a class="dropdown-item" href="{{ route('sector.mission.edit', $mission) }}">
            @icon('pen|mr:3|color:muted') {{ __('mission::mission._actions.edit') }}
        </a>
    @endcan

    @can('linkMissionToContract', $mission)
        <a class="dropdown-item" href="{{ route('contract_mission.create', ['mission' => $mission->getId()]) }}">
            @icon('link|mr:3|color:muted') {{ __('mission::mission._actions.link_contract') }}
        </a>
    @endcan

    @can('delete', $mission)
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('mission::mission._actions.delete') }} </span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('mission.destroy', $mission) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan

@endcomponent