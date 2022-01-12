<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('edenred.common.code._actions.actions') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">

@can('view', $code)
    <a class="dropdown-item" href="{{ route('edenred.common.code.show', $code) }}">
        <i class="text-muted mr-3 fa fa-eye"></i> {{ __('edenred.common.code._actions.consult') }}
    </a>
@endcan

@can('update', $code)
    <a class="dropdown-item" href="{{ route('edenred.common.code.edit', $code) }}">
        <i class="text-muted mr-3 fa fa-edit"></i> {{ __('edenred.common.code._actions.edit') }}
    </a>
@endcan

@can('show', skill())
    <a class="dropdown-item" href="{{ route('addworking.common.job.skill.show', [$code->skill->job, $code->skill]) }}">
        <i class="text-muted mr-3 fa fa-list"></i> {{ __('edenred.common.code._actions.skill') }}
    </a>
@endcan

@can('index', edenred_average_daily_rate())
    <a class="dropdown-item" href="{{ route('edenred.common.code.average_daily_rate.index', $code) }}">
        <i class="text-muted mr-3 fa fa-list"></i> {{ __('edenred.common.code._actions.average_daily_rates') }}
    </a>
@endcan

@can('delete', $code)
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#" onclick="confirm({{ __('edenred.common.code._actions.confirm_delete') }}) && document.forms['{{ $name = uniqid('form_') }}'].submit()">
        <i class="text-danger mr-3 fa fa-trash"></i> <span class="text-danger">{{ __('edenred.common.code._actions.remove') }}</span>
    </a>
    @push('modals')
        <form name="{{ $name }}" action="{{ route('edenred.common.code.destroy', $code) }}" method="POST">
            @method('DELETE')
            @csrf
        </form>
    @endpush
@endcan

    </div>
</div>
