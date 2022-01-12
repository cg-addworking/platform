<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">


@can('show', $onboarding_process)
    <a class="dropdown-item" href="{{ route('support.user.onboarding_process.show', $onboarding_process) }}">
        @icon('eye|color:muted|mr:3') Consulter
    </a>
@endcan

@can('update', $onboarding_process)
    <a class="dropdown-item" href="{{ route('support.user.onboarding_process.edit', $onboarding_process) }}">
        @icon('edit|color:muted|mr:3') Modifier
    </a>
@endcan

@can('destroy', $onboarding_process)
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
        @icon('trash-alt|color:danger|mr:3') <span class="text-danger">Supprimer</span>
    </a>

    @push('modals')
        <form name="{{ $name }}" action="{{ route('support.user.onboarding_process.destroy', $onboarding_process) }}" method="POST">
            @method('DELETE')
            @csrf
        </form>
    @endpush
@endcan

    </div>
</div>
