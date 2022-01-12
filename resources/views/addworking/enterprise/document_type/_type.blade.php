@php
    $types = Repository::documentType()->getAvailableTypes(true)
@endphp

@isset($types[$document_type->type])
    {{ $types[$document_type->type] }}
@else
    @na
@endif
