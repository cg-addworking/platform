<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('file-alt') {{ $document->documentType->display_name }}</legend>

    @form_group([
        'type'     => 'date',
        'text'     => __('addworking.enterprise.document._form_accept.expiration_date'),
        'name'     => "document.valid_until",
        'value'    => $document->valid_until ?? '',
        'required' => true,
    ])
</fieldset>
