<tr>
    <td>{{ $document_type_model->getShortId() }}</td>
    <td>{{ $document_type_model->getDisplayName() }}</td>
    <td>
        @if(is_null($document_type_model->getPublishedAt()))
            <span class="text-danger"><i class="fas fa-times"></i></span>
        @else
            <span class="text-success"><i class="fas fa-check"></i></span>
        @endif
    </td>
    <td>
        @if(strlen($document_type_model->getDescription()) > 50)
            {{ substr($document_type_model->getDescription(), 0, 50) }} ...
            <a href="#" tabindex="0" data-container="body" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="{{ $document_type_model->getDescription() }}">Voir plus</a>
        @else
            {{ $document_type_model->getDescription() }}
        @endif
    </td>
    <td class="text-right">
        @include('document_type_model::document_type_model._actions')
    </td>
</tr>
