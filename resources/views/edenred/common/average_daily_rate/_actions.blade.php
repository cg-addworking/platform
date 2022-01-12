<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('edenred.common.average_daily_rate._actions.actions') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">

@can('view', $average_daily_rate)
    <a class="dropdown-item" href="{{ route('edenred.common.code.average_daily_rate.show', [$average_daily_rate->code, $average_daily_rate]) }}">
        <i class="text-muted mr-3 fa fa-eye"></i> {{ __('edenred.common.average_daily_rate._actions.consult') }}
    </a>
@endcan

@can('update', $average_daily_rate)
    <a class="dropdown-item" href="{{ route('edenred.common.code.average_daily_rate.edit', [$average_daily_rate->code, $average_daily_rate]) }}">
        <i class="text-muted mr-3 fa fa-edit"></i> {{ __('edenred.common.average_daily_rate._actions.edit') }}
    </a>
@endcan

@can('show', $average_daily_rate->code)
    <a class="dropdown-item" href="{{ route('edenred.common.code.show', $average_daily_rate->code) }}">
        <i class="text-muted mr-3 fa fa-list"></i> {{ __('edenred.common.average_daily_rate._actions.code') }}
    </a>
@endcan

@can('delete', $average_daily_rate)
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
        <i class="text-danger mr-3 fa fa-trash"></i> <span class="text-danger">{{ __('edenred.common.average_daily_rate._actions.remove') }}</span>
    </a>
    @push('modals')
        <form name="{{ $name }}" action="{{ route('edenred.common.code.average_daily_rate.destroy', [$average_daily_rate->code, $average_daily_rate]) }}" method="POST">
            @method('DELETE')
            @csrf
        </form>
    @endpush
@endcan

    </div>
</div>
