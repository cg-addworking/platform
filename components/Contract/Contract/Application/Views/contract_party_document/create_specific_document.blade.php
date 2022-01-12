@extends('foundation::layout.app.create', ['action' => route('contract.party.document.store_without_document_type', ['contract' => $contract, 'enterprise' => $enterprise->id])."?contract_model_document_type={$document_type->id}", 'enctype' => "multipart/form-data"])

@section('title', __('addworking.enterprise.document.create.create_document')." {$document_type->display_name} pour {$enterprise->name}")

@push('stylesheets')
    <link href="{{ mix('css/filepond.css')  }}" rel="stylesheet">
    <link href="{{ mix('css/filepond-plugin-image-preview.css') }}" rel="stylesheet">
    <style>
        .filepond--root {
            cursor: pointer;
        }
    </style>
@endpush

@section('toolbar')
        @button(__('addworking.enterprise.document.create.return') ."|href:".route('contract.show', ['contract' => $contract])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document.create.company')."|href:{$document->enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$document->enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.document.create.document')."|href:{$document->routes->index}")
    @breadcrumb_item(__('addworking.enterprise.document.create.create_document')." " .$document_type->display_name ."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('file-alt') {{ $document_type->display_name ?? 'n/a'}}</legend>

        @if(request()->query('contract'))
            <input type="hidden" name="contract" value="{{request()->query('contract')}}">
        @endif

        <div class="form-group">
            <label id for="document_files[]">Fichier(s)*</label>
            @if ($document->documentType->description)
                <small class="form-text text-muted">{{ $document_type->description }}</small>
            @endif
            <input type="file" name="document_files[]" multiple="true" required>
        </div>

        @form_group([
            'type'     => "date",
            'name'     => "document.valid_from",
            'text'     => __('addworking.enterprise.document._form_create.publish_date'),
            'required' => true,
        ])

        @form_group([
            'type'     => "date",
            'name'     => "document.valid_until",
            'text'     => __('addworking.enterprise.document._form_create.expiration_date'),
        ])
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.enterprise.document.create.record')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="{{ mix('js/filepond-plugin-file-encode.js')  }}"></script>
    <script src="{{ mix('js/filepond-plugin-image-preview.js') }}"></script>
    <script src="{{ mix('js/filepond.js') }}"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileEncode);
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.create(document.querySelector('input[name="document_files[]"]'))
            .setOptions({
                allowImagePreview: true,
                allowMultiple: true,
                allowFileEncode: true,
                maxFiles: 10,
                required: true,
                labelIdle:  'Glissez / Déposez vos fichiers ou <span class="filepond--label-action"> Choisissez </span>',
            });
    </script>
@endpush
