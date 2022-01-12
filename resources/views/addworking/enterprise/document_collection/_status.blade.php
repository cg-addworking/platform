@php
    switch(true) {
        case($document_collection->rejected()):
            list($icon, $color, $content) = ["exclamation-circle", "danger", __('addworking.enterprise.document_collection._status.atleast_one_document_non_compliant')];
            break;

        case($document_collection->outdated());
            list($icon, $color, $content) = ["times-circle", "dark", __('addworking.enterprise.document_collection._status.atleast_one_document_out_dated')];
            break;

        case($document_collection->pending()):
            list($icon, $color, $content) = ["clock", "secondary", __('addworking.enterprise.document_collection._status.atleast_one_document_pending')];
            break;

        case($document_collection->validated());
            list($icon, $color, $content) = ["check-circle", "success", __('addworking.enterprise.document_collection._status.all_document_valid')];
            break;

        default:
            list($icon, $color, $content) = ["times-circle", "warning", __('addworking.enterprise.document_collection._status.no_document_received')];
            break;
    }
@endphp

<i class="fas fa-{{ $icon }} fa-2x text-{{ $color }}" tabindex="0" data-toggle="popover" data-trigger="hover" data-content="{{ $content }}"></i>
