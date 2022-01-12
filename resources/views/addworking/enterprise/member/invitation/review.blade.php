@extends('foundation::layout.auth')

@section('title', __('addworking.enterprise.member.invitation.review.join_company').": {$enterprise->name}")

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('addworking.enterprise.member.invitation.accept', ['token' => $token]) }}">
        @csrf

        @if($guest->id === null)
            @form_group([
                'type'       => "select",
                'name'       => "user.gender",
                'value'      => app()->environment('local') ? 'male' : null,
                'options'    => array_trans(array_mirror(user()::getAvailableGenders()), 'messages.gender.'),
                'required'   => true,
                'text'       => __('user.register.gender'),
            ])

            @form_group([
                'type'       => "text",
                'name'       => "user.firstname",
                'value'      => app()->environment('local') ? factory(user())->make()->firstname : null,
                'required'   => true,
                'text'       => __('user.register.firstname'),
            ])

            @form_group([
                'type'       => "text",
                'name'       => "user.lastname",
                'value'      => app()->environment('local') ? factory(user())->make()->lastname : null,
                'required'   => true,
                'text'       => __('user.register.lastname'),
            ])

            @form_group([
                'type'       => "text",
                'name'       => "user.email",
                'value'      => $guest->email,
                'required'   => true,
                'text'       => __('user.register.email'),
            ])

            <div class="input-group mb-2">
                <input type="hidden" required name="user[phone_number]" id="phone-number">
                <label class="input-group mr-5">{{ __('user.register.phone') }}</label>
                <input type="tel" required id="phone" class="form-control @error('user.phone_number') is-invalid @enderror" autocomplete="nope">
            </div>

            @form_group([
                'type'       => app()->environment('local') ? "text" : "password",
                'name'       => "user.password",
                'value'      => app()->environment('local') ? 'password' : null,
                'required'   => true,
                'text'       => __('messages.password'),
            ])

            @form_group([
                'type'       => app()->environment('local') ? "text" : "password",
                'name'       => "user.password_confirm",
                'value'      => null,
                'required'   => true,
                'text'       => __('user.register.password_confirm'),
            ])
        @endif

        @form_group([
            'type'       => "text",
            'name'       => "job_title",
            'value'      => $job_title,
            'required'   => true,
            'text'       => "Fonction",
        ])

        <div class="form-group pt-3">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="tos_accepted" required{{ app()->environment('local') ? ' checked' : '' }}> @lang('user.register.accept_tou') <a href="https://de.addworking.com/legal/cgu" target="_blank">@lang('messages.terms_of_use')</a>
                </label>
            </div>
        </div>

        @button(__('addworking.enterprise.member.invitation.review.rejoin')." {$enterprise->name}|type:submit")
    </form>

    @push('modals')
        @component('components.modal', ['id' => "terms-of-use"])
            @include("terms_of_use")
        @endcomponent
    @endpush
@endsection

@push('scripts')
    <script type="text/javascript">
        $('input[name="firstname"]').blur(function() {
            $(this).val($(this).val().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            }));
        });

        $('input[name="lastname"]').blur(function() {
            $(this).val($(this).val().toUpperCase());
        });

        $('input[name=email]').blur(function() {
            $(this).val($(this).val().toLowerCase());
        })
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
