@component('foundation::layout.app._actions')
    @if($data['authorizations']['edit'])
        <a class="dropdown-item" href="{{ route('work_field.edit', $data['id']) }}">
            @icon('pen|mr:3|color:muted') {{ __('work_field::workfield._actions.edit') }}
        </a>
    @endif
    @if($data['authorizations']['manage-contributors'])
        <a class="dropdown-item" href="{{ route('work_field_contributor.manage_contributors', $data['id']) }}">
            @icon('users-cog|mr:3|color:muted') {{ __('work_field::workfield._actions.manage_contributors') }}
        </a>
    @endif
    <a class="dropdown-item" href="{{ route('sector.mission.create') }}?workfield_id={{$data['id']}}">
        @icon('handshake|mr-3|color:muted') <span class="ml-3"> {{ __('work_field::workfield._actions.mission') }}</span>
    </a>
    <a class="dropdown-item" href="{{ route('sector.offer.create') }}?workfield_id={{$data['id']}}">
        @icon('file-contract|mr-3|color:muted') <span class="ml-3"> {{ __('work_field::workfield._actions.offer') }}</span>
    </a>
    @if($data['authorizations']['archive'])
        <a class="dropdown-item" href="{{ route('work_field.archive', $data['id']) }}" onclick="confirm('Confirmer l\'archivage ?')">
            @icon('archive|mr-3|color:warning') <span class="text-warning ml-3"> {{ __('work_field::workfield._actions.archive') }}</span>
        </a>
    @endif
    @if ($data['authorizations']['delete'])
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('work_field::workfield._actions.delete') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('work_field.delete', $data['id']) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endif
@endcomponent