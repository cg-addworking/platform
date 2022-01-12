<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('file-alt') {{ $document->documentType->display_name }}</legend>

    @if ($document->exists)
        <input type="hidden" name="document[id]" value="{{ $document->id }}">
    @endif

    @form_group([
        'text'  => "Status",
        'name'  => "document.status",
        'type'  => "select",
        'options' => document()::getAvailableStatuses(true),
        'value' => $document->status,
    ])

    @form_group([
        'text'  => __('addworking.enterprise.document._form.reject_reason'),
        'name'  => "document.reason_for_rejection",
        'type'  => "select",
        "options" => document()::getAvailableReasonsForRejection($document->documentType),
        'value' => $document->reason_for_rejection,
    ])

    @form_group([
        'text'  => __('addworking.enterprise.document._form.validity_start'),
        'name'  => "document.valid_from",
        'type'  => "date",
        'value' => $document->valid_from,
    ])

    @form_group([
        'text'  => __('addworking.enterprise.document._form.validity_end'),
        'name'  => "document.valid_until",
        'type'  => "date",
        'value' => $document->valid_until,
    ])

    @form_group([
        'text'  => __('addworking.enterprise.document._form.accept_by'),
        'name'  => "document.accepted_by",
        'type'  => "select",
        'options'  => enterprise()::addworking()->users->pluck('name', 'id'),
        'value' => $document->accepted_by,
    ])

    @form_group([
        'text'  => __('addworking.enterprise.document._form.accept_it'),
        'name'  => "document.accepted_at",
        'type'  => "date",
        'value' => $document->accepted_at,
    ])

    @form_group([
        'text'  => __('addworking.enterprise.document._form.reject_by'),
        'name'  => "document.rejected_by",
        'type'  => "select",
        'options'  => enterprise()::addworking()->users->pluck('name', 'id'),
        'value' => $document->rejected_by,
    ])

    @form_group([
        'text'  => __('addworking.enterprise.document._form.reject_on'),
        'name'  => "document.rejected_at",
        'type'  => "date",
        'value' => $document->rejected_at,
    ])
</fieldset>
