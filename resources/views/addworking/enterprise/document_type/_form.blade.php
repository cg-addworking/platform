<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') Informations Générales</legend>

    @form_group([
        'text'        => __('addworking.enterprise.document_type._form.is_mandatory'),
        'type'        => "select",
        'name'        => "type.is_mandatory",
        'options'     => [0 => "Non", 1 => "Oui"],
        'required'    => true,
        'value'       => optional($document_type)->is_mandatory
    ])

    @form_group([
        'text'        => __('addworking.enterprise.document_type._form.document_name'),
        'type'        => "text",
        'name'        => "type.display_name",
        'placeholder' => __('addworking.enterprise.document_type._form.example_driver_name'),
        'required'    => true,
        'value'       => optional($document_type)->display_name
        ])

    @form_group([
        'text'        => __('addworking.enterprise.document_type._form.document_type'),
        'type'        => "select",
        'name'        => "type.type",
        'options'     => Repository::documentType()->getAvailableTypes(true),
        'required'    => true,
        'value'       => optional($document_type)->type
    ])

    @form_group([
        'text'        => __('addworking.enterprise.document_type._form.validity_period'),
        'type'        => "number",
        'name'        => "type.validity_period",
        'placeholder' => "365",
        'min'         => 0,
        'help'        => __('addworking.enterprise.document_type._form.validity_period_days'),
        'value'       => optional($document_type)->validity_period
    ])

    @form_group([
        'text'        => __('addworking.enterprise.document_type._form.deadline_date'),
        'type'        => "text",
        'name'        => "document_type.deadline_date",
        'value'       => optional(optional($document_type)->getDeadlineDate())->format('y/m')
    ])

    @form_group([
        'text'        => __('addworking.enterprise.document_type._form.document_code'),
        'type'        => "text",
        'name'        => "type.code",
        'placeholder' => __('addworking.enterprise.document_type._form.exmaple_dmpc_v0'),
        'value'       => optional($document_type)->code
    ])

    @form_group([
        'text'        => __('addworking.enterprise.document_type._form.document_description'),
        'type'        => "textarea",
        'name'        => "type.description",
        'placeholder' => __('addworking.enterprise.document_type._form.enter_document_description'),
        'value'       => optional($document_type)->description
    ])

    @form_group([
        'text'        => __('addworking.enterprise.document_type._form.country_document'),
        'type'        => "select",
        'name'        => "type.country",
        'options'     => enterprise([])->getAvailableCountry(),
        'value'       => app()->currentLocale(),
    ])

    @form_group([
        'text'         => __('addworking.enterprise.document_type._form.request_document'),
        'type'         => "select",
        'name'         => "type.legal_form.",
        'value'        => $document_type->legalForms->pluck('id')->toArray(),
        'multiple'     => true,
        'id'           => 'legal-form-id',
        'selectpicker' => true,
        'search'       => true,
    ])

    <div class="form-group">
        <label>
            {{__('addworking.enterprise.document_type._form.needs_validation')}}
        </label>
        <select data-actions-box="1" name="type[needs_validation][]" multiple="1" class="form-control shadow-sm selectpicker">
            <option value="needs_support_validation" {{optional($document_type)->needs_support_validation ? 'selected' : ''}}>{{__('addworking.enterprise.document_type._form.support')}}</option>
            <option value="needs_customer_validation" {{optional($document_type)->needs_customer_validation ? 'selected' : ''}}>{{__('addworking.enterprise.document_type._form.customer')}}</option>
        </select>
    </div>

    <div class="card bg-light mb-3">
        <div class="card-body">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="type[is_automatically_generated]" class="custom-control-input" id="custom-check-generation" @if ($document_type->getIsAutomaticallyGenerated()) checked @endif>
                <label class="custom-control-label" for="custom-check-generation">{{__('addworking.enterprise.document_type._form.is_automatically_generated')}}</label>
            </div>
        </div>
    </div>

    <div class="card bg-light">
        <div class="card-body">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="type[need_an_authenticity_check]"  class="custom-control-input" id="custom-check-authenticity" @if ($document_type->getNeedAnAuthenticityCheck()) checked @endif>
                <label class="custom-control-label" for="custom-check-authenticity">{{__('addworking.enterprise.document_type._form.need_proof_authenticity')}}</label>
            </div>
        </div>
    </div>

    @form_group([
        'class'       => "mt-2",
        'text'        => __('addworking.enterprise.document_type._form.document_template'),
        'type'        => "file",
        'name'        => "type.file",
        'value'       => optional($document_type)->file
    ])
</fieldset>

@push('scripts')
    <script>
        $(function () {
            $('.selectpicker').selectpicker('refresh');
            $(document).ready(function() {
                callAjax($("select[name='type[country]']").val());
            });
            $("select[name='type[country]']").change(function () {
                callAjax($(this).val());
            });

            function callAjax(value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('addworking.enterprise.get_available_legal_forms') }}",
                    data: {
                        country: value
                    },
                    beforeSend: function () {
                        $("#legal-form-id option").remove();
                    },
                    success: function(response) {
                        $.each(response.data, function(id, display_name) {
                            $("#legal-form-id").append('<option value="'+id+'">'+display_name+'</option>');
                        });
                        $("#legal-form-id").selectpicker("refresh");
                    }
                });
            }
        });
    </script>
@endpush
