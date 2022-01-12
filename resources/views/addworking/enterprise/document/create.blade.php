@extends('foundation::layout.app.create', ['action' => "{$document->routes->store}?document_type={$document_type->id}", 'enctype' => "multipart/form-data"])

@section('title', __('addworking.enterprise.document.create.create_document') ." {$document->documentType->display_name} ".__('addworking.enterprise.document.create.create_document_2')." {$enterprise->name}")

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
    @if(request()->has('contract_party'))
        @button(__('addworking.enterprise.document.create.return') ."|href:".route('contract.party.document.index', ['contract' => $contract, 'contract_party'=> $contract_party])."|icon:arrow-left|color:secondary|outline|sm")
    @elseif(request()->has('contract'))
        @button(__('addworking.enterprise.document.create.return') ."|href:".route('contract.show', ['contract' => $contract])."|icon:arrow-left|color:secondary|outline|sm")
    @else
        @button(__('addworking.enterprise.document.create.return') ."|href:{$document->routes->index}|icon:arrow-left|color:secondary|outline|sm")
    @endif
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.document.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.document.create.company')."|href:{$document->enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$document->enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.document.create.document')."|href:{$document->routes->index}")
    @breadcrumb_item(__('addworking.enterprise.document.create.create_document')." {$document->documentType->display_name}|active")
@endsection

@section('form')
    {{ $document->views->form_create(['has_model' => $has_model]) }}

    <div class="text-right my-5">
        <button type="submit" class="btn btn-success" id="save_button" @if(! auth()->user()->isSupport()) disabled @endif >
            <i class="fas fa-check"></i>
            {{__('addworking.enterprise.document.create.record')}}
        </button>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="{{ mix('js/filepond-plugin-file-encode.js')  }}"></script>
    <script src="{{ mix('js/filepond-plugin-image-preview.js') }}"></script>
    <script src="{{ mix('js/filepond.js') }}"></script>
    <script>
        $('.document_type_model').click(function() {
            if($(this).is(':checked')){
                $('#save_button').attr("disabled", false);
                FilePond.create(document.querySelector('input[name="document_files[]"]'))
                    .setOptions({
                        disabled: true,
                    });
            }
        });
    </script>
    <script>
        @if(app()->getLocale() == 'de')
            let labelIdleKey = 'Drag / Drop Ihre Dateien oder wählen';
            let labelFileTypeNotAllowedKey = 'Das Format Ihrer Datei ist nicht PDF';
            let fileValidateTypeLabelExpectedTypesKey = 'Erforderliches Format ist PDF';
        @else
            let labelIdleKey = 'Glissez / Déposez vos fichiers ou <span class="filepond--label-action"> Choisissez </span>';
            let labelFileTypeNotAllowedKey = "Le fichier sélectionné n'est pas au format PDF";
            let fileValidateTypeLabelExpectedTypesKey = "Format accepté PDF";
        @endif

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
                labelIdle: labelIdleKey,
                acceptedFileTypes: ['application/pdf'],
                labelFileTypeNotAllowed: labelFileTypeNotAllowedKey,
                fileValidateTypeLabelExpectedTypes: fileValidateTypeLabelExpectedTypesKey,
            });
        $('#fraudulent_documents_message').click(function () {
            if ($(this).is(':checked')) {
                $('#save_button').attr("disabled", false);
            } else {
                $('#save_button').attr("disabled", true);
            }
        });
        $(function() {
            if($('.document_type_model').is(':checked')) {
                $('#save_button').attr("disabled", false);
            }
        });
    </script>
@endpush
