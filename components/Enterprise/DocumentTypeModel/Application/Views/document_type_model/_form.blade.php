<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('document_type_model::document_type_model._form.general_information') }}</legend>

    <div class="row">
        <div class="col-md-12">
            @form_group([
            'text'        => __('document_type_model::document_type_model._form.display_name'),
            'type'        => "text",
            'name'        => "document_type_model.display_name",
            'value'       => optional($document_type_model)->getDisplayName(),
            'required'    => true,
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @form_group([
            'text'        => __('document_type_model::document_type_model._form.description'),
            'type'        => "text",
            'name'        => "document_type_model.description",
            'value'       => optional($document_type_model)->getDescription(),
            'required'    => true,
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @form_group([
            'text'        => __('document_type_model::document_type_model._form.signature_page'),
            'type'        => "number",
            'name'        => "document_type_model.signature_page",
            'min'         => 1,
            'value'       => optional($document_type_model)->getSignaturePage(),
            'required'    => false,
            ])
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="document_type_model[is_primary]" {{optional($document_type_model)->getIsPrimary() ? 'checked' : ''}} class="form-check-input shadow-sm">
                    <label class="form-check-label">
                        {{__('document_type_model::document_type_model._form.is_primary')}}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="document_type_model[requires_documents]" {{optional($document_type_model)->getRequiresDocuments() ? 'checked' : ''}} class="form-check-input shadow-sm">
                    <label class="form-check-label">
                        {{__('document_type_model::document_type_model._form.requires_documents')}}
                    </label>
                </div>
            </div>
        </div>
    </div>
</fieldset>