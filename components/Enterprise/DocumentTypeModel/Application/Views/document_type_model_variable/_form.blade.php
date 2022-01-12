@inject('documentTypeModelVariableRepository', 'Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelVariableRepository')

<fieldset class="mt-5 pt-2">
    @foreach($items as $variable)
        <h5>{{$variable->getDisplayName()}}</h5>
        <div class="row">
            <div class="col-md-12">
                    @form_group([
                    'text'        => __('document_type_model::document_type_model_variable._form.type'),
                    'type'        => "select",
                    'name'        => "document_type_model_variable.{$variable->getId()}.type",
                    'value'       => $variable->getInputType() ?? '',
                    'options'     => $input_types,
                    'required'    => true,
                    ])
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @form_group([
                'text'     => __('document_type_model::document_type_model_variable._form.default_value'),
                'type'     => "text",
                'name'     => "document_type_model_variable.{$variable->getId()}.default_value",
                'value'    => $variable->getDefaultValue() ?? '',
                ])
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @form_group([
                'text'     => __('document_type_model::document_type_model_variable._form.description'),
                'type'     => "textarea",
                'rows'     => 2,
                'name'     => "document_type_model_variable.{$variable->getId()}.description",
                'value'    => $variable->getDescription() ?? '',
                ])
            </div>
        </div>
        <hr>
    @endforeach
</fieldset>