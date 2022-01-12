<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">

<a class="dropdown-item" href="{{ $site->routes->show }}">
    <i class="text-muted mr-3 fa fa-eye"></i> {{ __('addworking.enterprise.site._actions.to_consult') }}
</a>

    <a class="dropdown-item" href="{{ $site->routes->edit }}">
        <i class="text-muted mr-3 fa fa-edit"></i> @lang('messages.edit')
    </a>

@can('destroy', $site)
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
        <i class="text-danger mr-3 fa fa-trash"></i> <span class="text-danger">Supprimer</span>
    </a>

    @push('modals')
        <form name="{{ $name }}" action="{{ $site->routes->destroy }}" method="POST">
            @method('DELETE')
            @csrf
        </form>
    @endpush
@endif

    </div>
</div>
