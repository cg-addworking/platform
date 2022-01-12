<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('everial.mission.referential._actions.actions') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">

    @can('show', $referential)
        <a class="dropdown-item" href="{{ $referential->routes->show }}">
            @icon('eye|color:muted|mr:3') {{ __('everial.mission.referential._actions.consult') }}
        </a>
    @endcan

    @can('edit', $referential)
        <a class="dropdown-item" href="{{ $referential->routes->edit }}">
            @icon('edit|color:muted|mr:3') {{ __('everial.mission.referential._actions.edit') }}
        </a>
    @endcan

    @can('index', price())
        <a class="dropdown-item" href="{{ route('everial.mission.referential.price.index', $referential) }}">
            @icon('money-check-alt|color:muted|mr:3') {{ __('everial.mission.referential._actions.price_list') }}
        </a>
    @endcan

    @can('destroy', $referential)
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash|mr:3') {{ __('everial.mission.referential._actions.remove') }}
        </a>
        @push('modals')
            <form name="{{ $name }}" action="{{ $referential->routes->destroy }}" method="post">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan

    </div>
</div>
