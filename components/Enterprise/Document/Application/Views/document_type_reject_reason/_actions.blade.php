@component('foundation::layout.app._actions', ['model' => $document_type_reject_reason])
    @can('delete', $document_type_reject_reason)
            <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('document::document.document_type_reject_reason._actions.delete') }}</span>
            </a>

            @push('forms')
                <form name="{{ $name }}" action="{{ route('support.document_type_reject_reason.delete', [$enterprise, $document_type, $document_type_reject_reason]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                </form>
            @endpush
    @endcan
 
    @can('edit', $document_type_reject_reason)
        <a class="dropdown-item" href="{{ route('support.document_type_reject_reason.edit', [$enterprise, $document_type, $document_type_reject_reason]) }}">
            @icon('edit|mr:3|color:muted') {{ __('document::document.document_type_reject_reason._actions.edit') }}
        </a>
    @endcan
@endcomponent