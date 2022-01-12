<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('addworking.mission.mission_tracking._actions.actions') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">

@can('show', $mission_tracking)
    <a class="dropdown-item" href="{{ route('mission.tracking.show', ['tracking' => $mission_tracking, 'mission' => $mission_tracking->mission])}}">
        <i class="text-muted mr-3 fa fa-eye"></i> {{ __('addworking.mission.mission_tracking._actions.consult') }}
    </a>
@endcan

@can('edit', $mission_tracking)
    <a class="dropdown-item" href="{{ route('mission.tracking.edit', ['tracking' => $mission_tracking, 'mission' => $mission_tracking->mission])}}">
        <i class="text-muted mr-3 fa fa-pen"></i> {{ __('addworking.mission.mission_tracking._actions.edit') }}
    </a>
@endcan

@can('destroy', $mission_tracking)
    <a class="dropdown-item text-danger" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
        <i class="mr-3 fa fa-trash"></i> {{ __('addworking.mission.mission_tracking._actions.remove') }}
    </a>
    <form name="{{ $name }}" action="{{ route('mission.tracking.destroy', ['tracking' => $mission_tracking, 'mission' => $mission_tracking->mission]) }}" method="POST">
        @method('DELETE')
        @csrf
    </form>
@endcan
    </div>
</div>
