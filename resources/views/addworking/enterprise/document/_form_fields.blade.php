@if ($document->documentType->documentTypeFields()->exists())
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('plus') {{ __('addworking.enterprise.document._form_fields.additional_fields') }}</legend>

        @foreach ($document->documentType->documentTypeFields as $field)
            @form_group([
                'type'     => $field->input_type,
                'name'     => $field->input_name,
                'text'     => $field->display_name,
                'value'    => optional($document->fields()->findOrNew($field->id)->pivot)->content,
                'help'     => $field->help_text,
                'required' => $field->isMandatory(),
            ])
        @endforeach
    </fieldset>
@endif

