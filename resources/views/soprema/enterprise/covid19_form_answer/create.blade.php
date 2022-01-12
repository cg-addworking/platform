@extends('foundation::layout.app', ['_no_background' => true, '_no_shadow' => true, '_no_sidebar' => true, '_no_message' => true])

@section('main')
    <div class="row">
        <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3">
            <div class="card shadow">
                <div class="card-body">
                    @component('bootstrap::form', ['action' => $covid19_form_answer->routes->store, 'method' => "post"])
                        @if ($covid19_form_answer->vendor->exists)
                            <input type="hidden" name="covid19_form_answer[vendor_id]" value="{{ $covid19_form_answer->vendor->id }}">
                        @endif

                        <fieldset class="pt-2">
                            <legend class="text-primary h5">@icon('hands-helping') {{ __('soprema.enterprise.covid19_form_answer.create.covid19_form') }}</legend>

                            <div class="row">
                                <div class="@guest col-md-6 @else col-md-12 @endguest">
                                    @form_group([
                                        'text'        => __('soprema.enterprise.covid19_form_answer.create.social_reason'),
                                        'name'        => "covid19_form_answer.vendor_name",
                                        'value'       => $covid19_form_answer->vendor->name,
                                        'required'    => true,
                                    ])
                                </div>
                                @guest
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('soprema.enterprise.covid19_form_answer.create.or') }}</label>
                                            @button(__('soprema.enterprise.covid19_form_answer.create.already_have_addworking_account')."|href:{$covid19_form_answer->routes->login}|class:btn-block")
                                        </div>
                                    </div>
                                @endguest
                            </div>

                            @form_group([
                                'text'        => __('soprema.enterprise.covid19_form_answer.create.siret'),
                                'name'        => "covid19_form_answer.vendor_siret",
                                'value'       => $covid19_form_answer->vendor->identification_number,
                                'maxlength'   => 16,
                                'required'    => true,
                            ])

                            @if (request('enterprise'))
                                <input type="hidden" name="covid19_form_answer[customer_id]" value="{{ request('enterprise') }}">
                                @form_group([
                                    'text'         => __('soprema.enterprise.covid19_form_answer.create.your_client'),
                                    'disabled'     => true,
                                    'value'        => optional(enterprise()::whereId(request('enterprise'))->first())->name
                                ])
                            @elseif ($covid19_form_answer->vendor->customers()->exists())
                                {{ __('soprema.enterprise.covid19_form_answer.create.your_customers') }}
                                <ul class="list-group mb-3">
                                    @foreach ($covid19_form_answer->vendor->customers as $customer)
                                        <li class="list-group-item" style="padding: .375rem .75rem; box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);">{{ $customer->name }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            @form_group([
                                'text'        => __('soprema.enterprise.covid19_form_answer.create.activity_text1'),
                                'type'        => "select",
                                'options'     => [1 => __('soprema.enterprise.covid19_form_answer.create.yes'), 0 => __('soprema.enterprise.covid19_form_answer.create.no')],
                                'name'        => "covid19_form_answer.pursuit",
                                'required'    => true,
                            ])
                        </fieldset>
                        <fieldset class="pt-2 mt-4">
                            <legend class="text-primary h5">@icon('wrench') {{ __('soprema.enterprise.covid19_form_answer.create.construction_sites') }}</legend>

                            <p>{{ __('soprema.enterprise.covid19_form_answer.create.site_list_text1') }} :</p>

                            <ul>
                                <li>{{ __('soprema.enterprise.covid19_form_answer.create.site_number') }}</li>
                                <li>{{ __('soprema.enterprise.covid19_form_answer.create.contract_number') }}</li>
                                <li>{{ __('soprema.enterprise.covid19_form_answer.create.recovery_possibility') }}</li>
                                <li>{{ __('soprema.enterprise.covid19_form_answer.create.possible_recovery_date') }}</li>
                                <li>{{ __('soprema.enterprise.covid19_form_answer.create.constraints_preventing_recovery') }}</li>
                            </ul>

                            @form_group([
                                'text'        => __('soprema.enterprise.covid19_form_answer.create.construction_sites'),
                                'type'        => "textarea",
                                'name'        => "covid19_form_answer.message",
                                'rows'        => 10,
                                'required'    => true,
                            ])
                        </fieldset>

                        @button(__('soprema.enterprise.covid19_form_answer.create.save')."|type:submit|class:btn-block")
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection

@push('stylesheets')
    <style>
        body {
            background: #007bff;
        }

        main footer {
            color: white;
        }

        main footer a {
            color: inherit;
        }
    </style>
@endpush
