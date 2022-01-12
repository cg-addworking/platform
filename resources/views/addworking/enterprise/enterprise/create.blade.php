@extends('foundation::layout.app.create', ['action' => $action ?? $enterprise->routes->store])
@php
    $route = auth()->user()->isSupport() ? route('support.enterprise.index'): route('enterprise.index');
@endphp

@section('title', __('addworking.enterprise.enterprise.create.start_new_business'))

@section('toolbar')
    @button(__('addworking.enterprise.enterprise.create.return')."|href:".$route."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.enterprise.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.enterprise.create.enterprise').'|href:'.$route)
    @breadcrumb_item(__('addworking.enterprise.enterprise.create.create')."|active")
@endsection

@section('form')
    {{ $enterprise->views->form }}

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('highlighter') {{ __('addworking.enterprise.enterprise.create.activity') }}</legend>

        <div class="row">
            <div class="col-md-3">
                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.create.number_of_employees'),
                    'name'        => "enterprise_activity.employees_count",
                    'value'       => optional($enterprise->activity)->employees_count,
                    'type'        => "number",
                    'min'         => 0,
                    'step'        => 1,
                    'required'    => true,
                ])
            </div>
            <div class="col-md-3" id="enterprise_activity_field_input_container">
                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.create.sector'),
                    'name'        => "enterprise_activity.field",
                    'value'       => optional($enterprise->activity)->field,
                    'type'        => "select",
                    'options'     => enterprise_activity()::getAvailableFields(),
                    'required'    => true,
                ])
            </div>
            <div class="col-md-3">
                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.create.company_activity'),
                    'name'        => "enterprise_activity.activity",
                    'value'       => optional($enterprise->activity)->activity,
                    'type'        => "text",
                    'required'    => true,
                    'maxlength'   => 255,
                ])
            </div>
            <div class="col-md-3" id="code-ape-container-id">
                @form_group([
                    'text'        => "Code APE",
                    'type'        => "text",
                    'name'        => "enterprise.main_activity_code",
                    'value'       => optional($enterprise)->main_activity_code,
                    'required'    => true,
                    'placeholder' => "0000X",
                    'help'        => __('addworking.enterprise.enterprise.create.ape_code_help'),
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" id="departments-container-id">
                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.create.department'),
                    'name'        => "enterprise_activity.departments.",
                    'value'       => old('enterprise_activity.departments' , optional($enterprise->activity)->departments),
                    'type'        => "select",
                    'options'     => department()::options(),
                    'multiple'    => true,
                    'live_search' => true,
                    'help'        => __('addworking.enterprise.enterprise.create.department_help'),
                ])
            </div>
        </div>
    </fieldset>

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('map-marker-alt') {{ __('addworking.enterprise.enterprise.create.main_address') }}</legend>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.create.address_line_1'),
                    'type'        => "text",
                    'name'        => "address.address",
                    'value'       => optional($enterprise->address)->address,
                    'required'    => true,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.create.address_line_2'),
                    'type'        => "text",
                    'name'        => "address.additionnal_address",
                    'value'       => optional($enterprise->address)->additionnal_address,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.create.postal_code'),
                    'type'        => "text",
                    'name'        => "address.zipcode",
                    'value'       => optional($enterprise->address)->zipcode,
                    'required'    => true,
                ])
            </div>
            <div class="col-md-7">
                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.create.city'),
                    'type'        => "text",
                    'name'        => "address.town",
                    'value'       => optional($enterprise->address)->town,
                    'required'    => true,
                ])
            </div>
            <div class="col-md-2">
                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.create.country'),
                    'type'        => "select",
                    'name'        => "address.country",
                    'value'       => app()->currentLocale() ?? $enterprise->address->country,
                    'options'     => enterprise([])->getAvailableCountry(),
                    'required'    => true,
                ])
            </div>
        </div>
    </fieldset>

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('phone') {{ __('addworking.enterprise.enterprise.create.contact')}}</legend>

        <div class="row">
            <input type="hidden" name="phone_number[1][number]" id="phone-number-1" value="{{old('phone_number.1.number', optional($phone_number)->number)}}">
            <div class="col-md-3">
                <label>{{ __('addworking.enterprise.enterprise.create.telephone_1')}}<span class="text-danger ml-1">*</span></label><br>
                <input type="tel" value="{{old('phone_number.1.number', optional($phone_number)->number)}}" required id="phone-1" class="form-control @error('phone_number[1][number]') is-invalid @enderror" autocomplete="nope">
            </div>
            <div class="col-md-9">
                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.create.note'),
                    'type'        => "text",
                    'name'        => "phone_number.1.note",
                    'value'       => optional($enterprise->phone_number)->note,
                ])
            </div>
        </div>

        <div class="row">
            <input type="hidden" name="phone_number[2][number]" id="phone-number-2">
            <div class="col-md-3">
                <label>{{ __('addworking.enterprise.enterprise.create.telephone_2')}}</label><br>
                <input type="tel" id="phone-2" class="form-control">
            </div>
            <div class="col-md-9">
                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.create.note'),
                    'type'        => "text",
                    'name'        => "phone_number.2.note",
                ])
            </div>
        </div>


        <div class="row">
            <input type="hidden" name="phone_number[3][number]" id="phone-number-3">
            <div class="col-md-3">
                <label>{{ __('addworking.enterprise.enterprise.create.telephone_3')}}</label><br>
                <input type="tel" id="phone-3" class="form-control">
            </div>
            <div class="col-md-9">
                @form_group([
                    'text'        => __('addworking.enterprise.enterprise.create.note'),
                    'type'        => "text",
                    'name'        => "phone_number.3.note",
                ])
            </div>
        </div>
    </fieldset>

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('map-marker-alt') {{ __('addworking.enterprise.enterprise.create.job_title_in_company') }}</legend>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                'text'     => __('addworking.enterprise.enterprise.create.user_job_title'),
                'type'     => "text",
                'name'     => "member.job_title",
                'value'    => optional($enterprise->address)->address,
                'required' => true,
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.enterprise.enterprise.create.create_company')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput-jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">

    <script>
        $('#phone-1, #phone-2, #phone-3').intlTelInput({
            initialCountry: "fr",
            separateDialCode: true,
            preferredCountries: ["fr"],
            onlyCountries: ["fr", "de", "be"],
            formatOnDisplay: true,
            geoIpLookup: function (callback) {
                $.get('https://ipinfo.io', function () {
                }, "jsonp").always(function (resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "fr";
                    callback(countryCode);
                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.min.js"
        });

        $('#phone-1, #phone-2, #phone-3').on('keyup change', function (e) {
            if ($(this).intlTelInput('isValidNumber')) {
                var i = $(this).attr('id').split('-')[1];
                $('#phone-number-'+i).val($(this).intlTelInput('getNumber'));
            };
        });
    </script>

    <script>
        $('input[name="enterprise[name]"],input[name="enterprise[registration_town]"]').blur(function() {
            $(this).val($(this).val().toUpperCase());
        });

        $(function () {
            $(document).ready(function() {
                callAjax($("select[name='enterprise[country]']").val());
            });

            $("select[name='enterprise[country]']").change(function () {
                callAjax($(this).val());
            });

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
                        if (id == "{{old('enterprise.legal_form_id')}}") {
                            $("#legal-form-id").append('<option value="'+id+'" selected>'+display_name+'</option>');
                        } else {
                            $("#legal-form-id").append('<option value="'+id+'">'+display_name+'</option>');
                        }
                    });
                    if (value != "fr") {
                        $("#code-ape-container-id").hide();
                        $("#departments-container-id").hide();
                        $("#departments-container-id select[name^='enterprise_activity[departments]']").attr('required', false);
                        $("#departments-container-id select[name^='enterprise_activity[departments]']").prop('disabled', true);
                        $("input[name='enterprise[main_activity_code]']").attr('required', false);
                        $("input[name='enterprise[main_activity_code]']").prop('disabled', true);
                    } else {
                        $("#code-ape-container-id").show();
                        $("#departments-container-id").show();
                        $("#departments-container-id select[name^='enterprise_activity[departments]']").prop('disabled', false);
                        $("#departments-container-id select[name^='enterprise_activity[departments]']").attr('required', true);
                        $("input[name='enterprise[main_activity_code]']").prop('disabled', false);
                        $("input[name='enterprise[main_activity_code]']").attr('required', true);
                    }
                },
            });
        }

    var check_enterprise_country = function (value) {
        if (value === '{{\Components\Common\Common\Domain\Interfaces\Entities\CountryEntityInterface::CODE_DEUTSCHLAND}}') {
            $("#div_main_activity_code").hide();
            $("#external_id_input_container").hide();
            $('#div_contractualization_language').show();
            $("select[name='enterprise[contractualization_language]']").prop('disabled', false);
            $("select[name='enterprise[contractualization_language]']").attr('required', true);
            $("input[name='enterprise[main_activity_code]']").prop('disabled', true);
            $("input[name='enterprise[main_activity_code]']").attr('required', false);
            $('#enterprise_activity_field_input_container').hide();
            $("select[name='enterprise_activity[field]']").prop('disabled', true);
            $("select[name='enterprise_activity[field]']").attr('required', false);
            $('#siret-number-input-container label').text("{{__('addworking.enterprise.enterprise._form.siret_number', [], 'de')}}");
            $('#siret-number-input-container small').text("{{__('addworking.enterprise.enterprise._form.siren_14_digit_help', [], 'de')}}");
            $("input[name='enterprise[registration_date]']").attr('required', true);
            $("#div_registration_date").show();
            $('#tax_identification_number_input_container input').attr('placeholder', 'DE1234');
            $('#siret-number-input-container input').attr('placeholder', '');
            $('#siret-number-input-container small').attr('placeholder', '');
        } else {
            $("#div_main_activity_code").show();
            $("#external_id_input_container").show();
            $('#div_contractualization_language').hide();
            $("select[name='enterprise[contractualization_language]']").prop('disabled', true);
            $("select[name='enterprise[contractualization_language]']").attr('required', false);
            $("input[name='enterprise[main_activity_code]']").prop('disabled', false);
            $("input[name='enterprise[main_activity_code]']").attr('required', true);
            $('#enterprise_activity_field_input_container').show();
            $("select[name='enterprise_activity[field]']").prop('disabled', false);
            $("select[name='enterprise_activity[field]']").attr('required', true);
            $('#siret-number-input-container label').text("{{__('addworking.enterprise.enterprise._form.siret_number', [], 'fr')}}");
            $('#siret-number-input-container small').text("{{__('addworking.enterprise.enterprise._form.siren_14_digit_help', [], 'fr')}}");
            $("input[name='enterprise[registration_date]']").attr('required', false);
            $("#div_registration_date").hide();
            $('#tax_identification_number_input_container input').attr('placeholder', 'FR99999999999');
            $('#siret-number-input-container input').attr('placeholder', '99999999999999');
        }
    };

    $('#enterprise_country').on('change', function() {
        const selected_enterprise_country = $(this).val();
        check_enterprise_country(selected_enterprise_country);
    })

    check_enterprise_country($('#enterprise_country').val());

</script>
@endpush
