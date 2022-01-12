@extends('foundation::layout.app.create', ['action' => route('addworking.enterprise.phone_number.store', $enterprise)])

@section('title', __('addworking.enterprise.phone_number.create.add_phone_number')." $enterprise->name")

@section('toolbar')
    @button(__('addworking.enterprise.phone_number.create.return')."|href:".route('enterprise.show', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.phone_number.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item('Entreprises|href:'.route('enterprise.index') )
    @breadcrumb_item(title_case($enterprise->name) .'|href:'.route('enterprise.show', $enterprise) )
    @breadcrumb_item(__('addworking.enterprise.phone_number.create.phone_number')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('phone') {{ __('addworking.enterprise.phone_number.create.phone') }}</legend>
        <div class="row">
            <input type="hidden" name="phone_number[number]" id="phone-number">
            <div class="col-md-3">
                <label>{{ __('addworking.common.phone_number._form.number') }}</label>
                <input type="tel" required id="phone" class="form-control @error('phone_number[number]') is-invalid @enderror" autocomplete="nope">
            </div>
            <div class="col-md-9">
                @form_group([
                    'text'        => __('addworking.common.phone_number._form.note'),
                    'type'        => "text",
                    'name'        => "phone_number.note",
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.enterprise.phone_number.create.record')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput-jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">

    <script>
        $('#phone').intlTelInput({
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

        $('#phone').on('keyup change', function (e) {
            if ($(this).intlTelInput('isValidNumber')) {
                $('#phone-number').val($(this).intlTelInput('getNumber'));
            };
        });
    </script>
@endpush