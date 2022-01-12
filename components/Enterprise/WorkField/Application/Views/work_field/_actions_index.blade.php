@component('foundation::layout.app._actions')
    @can('show', $work_field)
        <a class="dropdown-item" href="{{ route('work_field.show', $work_field) }}">
            @icon('eye|mr:3|color:muted') {{ __('work_field::workfield._actions.show') }}
        </a>
    @endcan
    @can('edit', $work_field)
        <a class="dropdown-item" href="{{ route('work_field.edit', $work_field) }}">
            @icon('pen|mr:3|color:muted') {{ __('work_field::workfield._actions.edit') }}
        </a>
    @endcan
    @can('archive', $work_field)
        <a class="dropdown-item" href="{{ route('work_field.archive', $work_field) }}" onclick="confirm('Confirmer l\'archivage ?')">
            @icon('file|mr-3|color:warning') <span class="text-warning ml-3"> {{ __('work_field::workfield._actions.archive') }}</span>
        </a>
    @endcan
    @can('delete', $work_field)
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('work_field::workfield._actions.delete') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('work_field.delete', $work_field) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan
@endcomponent