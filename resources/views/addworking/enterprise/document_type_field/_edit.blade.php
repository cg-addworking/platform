@component('components.form.modal', [
    'id' => "update-document-type-field-{$field->id}",
    'action' => $field->routes->update . '?back',
    'enctype' => "enctype=multipart/form-data"])
    @method('put')
    
    @slot('title')
        {{ __('addworking.enterprise.document_type_field._edit.edit_field') }}  {{ $field->display_name }}
    @endslot

    <div class="row">
       @component('components.form.group', [
            'class'    => 'col-md-12',
            'type'     => 'text',
            'name'     => "field.display_name",
            'required' => true,
            'value'    => $field->display_name,
        ])
            @slot('label')
                {{ __('addworking.enterprise.document_type_field._edit.filed_name') }}
            @endslot
        @endcomponent

        @component('components.form.group', [
            'class'    => 'col-md-12',
            'type'     => 'select',
            'name'     => "field.input_type",
            'required' => true,
            'values'   => array_trans(array_mirror(document_type_field()::getAvailableInputTypes()), 'document.type.field.input_type.'),
            'value'    => $field->input_type,
        ])
            @slot('label')
                {{ __('addworking.enterprise.document_type_field._edit.filed_type') }}
            @endslot
        @endcomponent

        @component('components.form.group', [
            'class'    => 'col-md-12',
            'type'     => 'textarea',
            'name'     => "field.help_text",
            'required' => false,
            'value'    => $field->help_text,
        ])
            @slot('label')
                {{ __('addworking.enterprise.document_type_field._edit.bubble_info') }}
            @endslot
        @endcomponent

        @component('components.form.group', [
            'class'    => 'col-md-12',
            'type'     => 'select',
            'name'     => "field.is_mandatory",
            'required' => true,
            'values'   => [0 => 'Non', 1 => 'Oui'],
            'value'    => $field->is_mandatory,
        ])
            @slot('label')
                {{ __('addworking.enterprise.document_type_field._edit.required_filed') }}
            @endslot
        @endcomponent
    </div>

@endcomponent