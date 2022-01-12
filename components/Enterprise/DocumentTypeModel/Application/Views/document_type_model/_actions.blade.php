@component('foundation::layout.app._actions', ['model' => $document_type_model])
    @can('show', $document_type_model)
        <a class="dropdown-item" href="{{ route('document_type_model.show', [$enterprise, $document_type, $document_type_model]) }}">
            @icon('eye|mr:3|color:muted') {{ __('document_type_model::document_type_model._actions.consult') }}
        </a>
    @endcan
    @can('edit', $document_type_model)
        <a class="dropdown-item" href="{{ route('document_type_model.edit', [$enterprise, $document_type, $document_type_model]) }}">
            @icon('edit|mr:3|color:muted') {{ __('document_type_model::document_type_model._actions.edit') }}
        </a>
    @endcan

    @can('publish', $document_type_model)
        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la publication ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('eye|mr-3|color:success') <span class="text-success ml-3"> {{ __('document_type_model::document_type_model._actions.publish') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('document_type_model.publish', [$enterprise, $document_type,$document_type_model]) }}" method="POST">
                @method('PUT')
                @csrf
            </form>
        @endpush
    @endcan

    @can('unpublish', $document_type_model)
        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la dépublication ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('undo|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('document_type_model::document_type_model._actions.unpublish') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('document_type_model.unpublish', [$enterprise, $document_type,$document_type_model]) }}" method="POST">
                @method('PUT')
                @csrf
            </form>
        @endpush
    @endcan
 
    @can('delete', $document_type_model)
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
        @icon('trash-alt|mr-3|color:danger') <span class="text-danger ml-3"> {{ __('document_type_model::document_type_model._actions.delete') }}</span>
        </a>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('document_type_model.delete', [$enterprise, $document_type,$document_type_model]) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endcan
@endcomponent