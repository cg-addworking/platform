@component('components.form.modal', [
    'id' => "store-document-type-model-{$type->id}",
    'action' => $type->routes->model_store . '?back',
    'enctype' => "enctype=multipart/form-data"
])
    @slot('title')
        {{ __('addworking.enterprise.document_type._add_model.add_modify_template') }}
    @endslot

    @component('components.form.group', [
        'type' => 'file',
        'name' => "document.type.file",
        'accept'      => 'application/pdf',
    ])
        @slot('label')
            {{ __('addworking.enterprise.document_type._add_model.file') }}
        @endslot
    @endcomponent
@endcomponent