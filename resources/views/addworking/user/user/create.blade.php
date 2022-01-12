@extends('foundation::layout.app.create', ['action' => $user->routes->store])

@section('title', __('addworking.user.user.create.create_new_user'));

@section('toolbar')
    @button(__('addworking.user.user.create.return')."|href:".route('user.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.user.user.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.user.user.create.users').'|href:'.$user->routes->index )
    @breadcrumb_item(__('addworking.user.user.create.create')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.user.user.create.general_information') }}</legend>

        <div class="row">
            <div class="col-md-2">
                @form_group([
                    'type'     => "select",
                    'options'  => array_trans(array_mirror(user()::getAvailableGenders()), 'messages.gender.'),
                    'name'     => "user.gender",
                    'value'    => optional($user)->gender,
                    'text'     => __('user.user.gender'),
                    'required' => true,
                ])
            </div>
            <div class="col-md-5">
                @form_group([
                    'type'     => "text",
                    'name'     => "user.firstname",
                    'value'    => optional($user)->firstname,
                    'text'     => __('user.user.firstname'),
                    'required' => true,
                ])
            </div>
            <div class="col-md-5">
                @form_group([
                    'type'     => "text",
                    'name'     => "user.lastname",
                    'value'    => optional($user)->lastname,
                    'text'     => __('user.user.lastname'),
                    'required' => true,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                @form_group([
                    'type'     => "email",
                    'name'     => "user.email",
                    'value'    => optional($user)->email,
                    'text'     => __('user.user.email'),
                    'required' => true,
                ])
            </div>

            <div class="col-md-5">
                <div class="input-group mb-2">
                    <input type="hidden" required name="user[phone_number]" id="phone-number">
                    <label class="input-group mr-5">{{ __('user.user.phone') }}</label>
                    <input type="tel" required id="phone" class="form-control @error('phone_number') is-invalid @enderror" autocomplete="nope">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'type'     => "password",
                    'name'     => "user.password",
                    'value'    => optional($user)->password,
                    'text'     => "Mot de passe",
                    'required' => true,
                ])
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @form_group([
                    'type'     => "password",
                    'name'     => "user.password_confirm",
                    'value'    => optional($user)->password,
                    'text'     => "Confirmer le mot de passe",
                    'required' => true,
                ])
            </div>
        </div>
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.user.user.create.create_user')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection

@push('scripts')
    <script>
        $('input[name="user[firstname]"]').blur(function() {
            $(this).val($(this).val().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            }));
        });

        $('input[name="user[lastname]"]').blur(function() {
            $(this).val($(this).val().toUpperCase());
        });

        $('input[name="user[email]"]').blur(function() {
            $(this).val($(this).val().toLowerCase());
        });
    </script>

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
