@inject('documentTypeRejectReasonRepository', 'Components\Enterprise\Document\Application\Repositories\DocumentTypeRejectReasonRepository')

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('document::document.document_type_reject_reason._form.general_information') }}</legend>

    @form_group([
        'text'     => __('document::document.document_type_reject_reason._form.display_name'),
        'type'     => "text",
        'name'     => "document_type_reject_reason.display_name",
        'value'    => optional($document_type_reject_reason)->getName(),
        'required' => true,
    ])

    @form_group([
        'text'     => __('document::document.document_type_reject_reason._form.message'),
        'type'     => "textarea",
        'rows'     => 8,
        'name'     => "document_type_reject_reason.message",
        'value'    => optional($document_type_reject_reason)->getMessage(),
        'required' => true,
    ])

    <div class="form-group form-check">
        @if($page == 'edit')
            <input type="checkbox" class="form-check-input" id="is-universal" name="document_type_reject_reason[is_universal]" value="1" {{ ! $documentTypeRejectReasonRepository->isUniversal($document_type_reject_reason) ?: 'checked' }}>
        @else
            <input type="checkbox" class="form-check-input" id="is-universal" name="document_type_reject_reason[is_universal]" value="1">
        @endif

        <label class="form-check-label" for="is-universal">{{ __('document::document.document_type_reject_reason._form.is_universal') }}</label>
    </div>
</fieldset>
