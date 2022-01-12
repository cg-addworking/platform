@extends('foundation::layout.app.create', ['action' => $action ?? $offer->routes->store, 'enctype' => 'multipart/form-data'])

@section('title', __('addworking.mission.offer.create.new_mission_offer'))

@section('toolbar')
    @button(__('addworking.mission.offer.create.return')."|href:".route($back ?? 'mission.offer.index')."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.offer.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.offer.create.mission_offer').'|href:'.route($back ?? 'mission.offer.index') )
    @breadcrumb_item(__('addworking.mission.offer.create.create')."|active")
@endsection

@section('form')
    <div class="row">
        <div class="col-md-12">
            @component('components.panel')
                <legend class="text-primary h5">@icon('info') Client</legend>

                @section('form.customer.id')
                    @if(auth()->user()->isSupport())
                        @form_group([
                            'text'        => "Client",
                            'type'        => "select",
                            'name'        => "customer.id",
                            'value'       => $offer->customer->id,
                            'options'     => $customers,
                            'required'    => true,
                        ])
                    @endif

                    @if(auth()->user()->enterprise->is_customer)
                        @form_group([
                            'type'        => "select",
                            'name'        => "customer.id",
                            'value'       => auth()->user()->enterprise->id,
                            'options'     => auth()->user()->enterprises->pluck('name', 'id'),
                            'required'    => true,
                        ])
                    @endif
                @show
            @endcomponent

            @component('components.panel')
                <legend class="text-primary h5">@icon('info') {{ __('addworking.mission.offer.create.assignment_offer_info') }}</legend>

                <div class="row">
                    <div class="col-md-12">
                        @section('form.label')
                            @form_group([
                                'type'        => "text",
                                'name'        => "mission_offer.label",
                                'required'    => true,
                                'value'       => $offer->label,
                                'text'        => __('addworking.mission.offer.create.assignment_purpose'),
                                'placeholder' => __('addworking.mission.offer.create.project_development_help'),
                            ])

                            @if(auth()->user()->enterprise->is_customer)
                                @form_group([
                                    'type'         => "select",
                                    'text'         => __('addworking.mission.offer.create.assignment_desired_skills'),
                                    'name'         => "mission_offer.skills.",
                                    'value'        => request()->input('mission_offer.skills', []),
                                    'options'      => $jobs->mapWithKeys(function ($job) { return [$job->display_name => $job->skills->pluck('display_name', 'id')]; }),
                                    'selectpicker' => true,
                                    'multiple'     => true,
                                    'search'       => true
                                ])
                            @endif
                        @show
                    </div>
                </div>

                @section('form.department')
                    <div class="row">
                        <div class="col-md-12">
                            @form_group([
                                'text'        => "Lieu",
                                'name'        => "department.id.",
                                'value'       =>  $offer->departments->pluck('id')->toArray(),
                                'type'        => "select",
                                'options'     => department()::options(),
                                'multiple'    => true,
                                'live_search' => true,
                                'help'        => __('addworking.mission.offer.create.select_multiple_departments_help'),
                            ])
                        </div>
                    </div>
                @show

                {{ $offer->views->form(['hide_analytic_code' => $hide_analytic_code ?? false]) }}

                @form_group([
                    'type'        => "file",
                    'name'        => "mission_offer.file.",
                    'required'    => false,
                    'accept'      => 'application/pdf',
                    'text'       => __('addworking.mission.offer.create.additional_file'),
                    'multiple'    => true,
                ])
            @endcomponent

            <div class="text-right my-5">
                @section('form.buttons')
                    <input type="hidden" name="mission_offer[status]" value="">

                    <button type="submit" id="draft_offer_btn" name="mission_offer[status]" value="{{ mission_offer()::STATUS_DRAFT }}" class="border btn btn-light"><i class="fa fa-check"></i> @lang('messages.save_draft')</button>
                    <button type="submit" id="to_provide_offer_btn" name="mission_offer[status]" value="{{ mission_offer()::STATUS_TO_PROVIDE }}" class="btn btn-success"><i class="fa fa-check"></i> @lang('messages.save')</button>
                @show
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $( document ).ready(function() {
            $("#draft_offer_btn").click(function() {
                const submit_value = $(this).val();
                $('input[name="mission_offer[status]"]').val(submit_value);
            });

            $("#to_provide_offer_btn").click(function() {
                const submit_value = $(this).val();
                $('input[name="mission_offer[status]"]').val(submit_value);
            });
        });
    </script>
@endpush
