@component('components.form.modal', [
    'id' => "create-document-type-field-{$type->id}",
    'action' => document_type_field([])->documentType()->associate($type)->routes->store . '?back',
    'enctype' => "enctype=multipart/form-data"])
    
    @slot('title')
        {{ __('addworking.enterprise.document_type_field._create.add_modify_field') }}
    @endslot

    <input type="hidden" name="field[type_id]" value="{{ $type->id }}">

    <div class="row">
       @component('components.form.group', [
            'class' => 'col-md-12',
            'type' => 'text',
            'name' => "field.display_name",
            'required' => true,
        ])
            @slot('label')
                {{ __('addworking.enterprise.document_type_field._create.filed_name') }}
            @endslot
        @endcomponent

        @component('components.form.group', [
            'class' => 'col-md-12',
            'type' => 'select',
            'name' => "field.input_type",
            'required' => true,
            'values' => array_trans(array_mirror(document_type_field()::getAvailableInputTypes())),
        ])
            @slot('label')
                {{ __('addworking.enterprise.document_type_field._create.filed_type') }}
            @endslot
        @endcomponent

        @component('components.form.group', [
            'class' => 'col-md-12',
            'type' => 'textarea',
            'name' => "field.help_text",
            'required' => false,
        ])
            @slot('label')
                {{ __('addworking.enterprise.document_type_field._create.bubble_info') }}
            @endslot
        @endcomponent

        @component('components.form.group', [
            'class' => 'col-md-12',
            'type' => 'select',
            'name' => "field.is_mandatory",
            'required' => true,
            'values' => [0 => 'Non', 1 => 'Oui'],
        ])
            @slot('label')
                {{ __('addworking.enterprise.document_type_field._create.required_filed') }}
            @endslot
        @endcomponent
    </div>

@endcomponent