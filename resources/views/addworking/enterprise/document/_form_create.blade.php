<fieldset class="mt-5 pt-2">
    @if(!$has_model)
        <div class="form-check">
            <input class="form-check-input file" type="radio" name="document[choice]" value="file" checked>
            <label class="form-check-label">
                <legend class="text-primary h5">{{ $document->documentType->display_name }}</legend>
            </label>
        </div>

        @if(request()->query('contract_party'))
            <input type="hidden" name="contract_party" value="{{request()->query('contract_party')}}">
        @endif

        @if(request()->query('contract'))
            <input type="hidden" name="contract" value="{{request()->query('contract')}}">
        @endif


        <div id="collapse-document">
            <div class="form-group">
                <label for="document_files[]"> {{ __('addworking.enterprise.document._form_create.files') }} @if($document->documentType->isMandatory())*@endif</label>
                @if ($document->documentType->description)
                    <small class="form-text text-muted">{{ $document->documentType->description }}</small>
                @endif
                <input type="file" name="document_files[]" multiple="true" @if($document->documentType->isMandatory()) required @endif>
            </div>

            @form_group([
                'type'     => "date",
                'name'     => "document.valid_from",
                'text'     => __('addworking.enterprise.document._form_create.publish_date'),
            ])

            @form_group([
                'type'     => "date",
                'name'     => "document.valid_until",
                'text'     => __('addworking.enterprise.document._form_create.expiration_date'),
            ])

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
                        ])
                    @endforeach
                </fieldset>
            @endif

            @if(! auth()->user()->isSupport())
                <div class="form-group pt-3">
                    <div class="checkbox">
                        <label class="font-italic">
                            <input type="checkbox" id="fraudulent_documents_message"  value="0">
                            {{ __('addworking.enterprise.document.create.message') }} <br>
                            {{ __('addworking.enterprise.document.create.sentence_one') }} <br>
                            {{ __('addworking.enterprise.document.create.sentence_two') }} <br>
                            {{ __('addworking.enterprise.document.create.sentence_three') }} <br>
                            {{ __('addworking.enterprise.document.create.sentence_four') }} <br>
                            {{ __('addworking.enterprise.document.create.sentence_five') }}
                            {{ __('addworking.enterprise.document.create.sentence_six') }}
                        </label>
                    </div>
                </div>
            @endif
        </div>
    @endif

    @foreach($document->documentType->getDocumentTypeModels() as $document_model)
        @if ($document_model->getIsPrimary())
            <div class="form-check">
                <input class="form-check-input document_type_model" type="radio" name="document[choice]" value="{{$document_model->getId()}}" checked>
                <label class="form-check-label">
                    <legend class="text-primary h5 mb-0"> {{ $document_model->getDisplayName() }}</legend> <br>
                    <p class="text-secondary">{{ $document_model->getDescription() }}</p>
                </label>
                <br>
            </div>
        @else
            <div class="form-check">
                <input class="form-check-input document_type_model" type="radio" name="document[choice]" value="{{$document_model->getId()}}">
                <label class="form-check-label">
                    <legend class="text-primary h5 mb-0">{{ $document_model->getDisplayName() }}</legend> <br>
                    <p class="text-secondary">{{ $document_model->getDescription() }}</p>
                </label>
                <br>
            </div>
        @endif
    @endforeach
</fieldset>

@push('scripts')
    <script>
        $(function() {
            if($('.document_type_model').is(':checked')) {
                $('#collapse-document').addClass("collapse");
            }
        });
        $('.document_type_model').click(function() {
            if($(this).is(':checked')){
                $('#collapse-document').removeClass("collapsed");
                $('#collapse-document').addClass("collapse");
            } else {
                $('#collapse-document').removeClass("collapse");
                $('#collapse-document').addClass("collapsed");
            }
        });
        $('.file').click(function() {
            if($(this).is(':checked')){
                $('#collapse-document').removeClass("collapse");
                $('#collapse-document').addClass("collapsed");
            } else {
                $('#collapse-document').removeClass("collapsed");
                $('#collapse-document').addClass("collapse");
            }
        });
    </script>
@endpush