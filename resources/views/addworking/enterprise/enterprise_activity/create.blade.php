@extends('foundation::layout.app.create', ['action' => route('enterprise.activity.store', $enterprise)])

@section('title', 'Créer une nouvelle activité')

@section('toolbar')
    @button(__('addworking.enterprise.enterprise_activity.create.return')."|href:".route('enterprise.activity.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.enterprise_activity.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item('Entreprises|href:'.route('enterprise.index') )
    @breadcrumb_item('Activités|href:'.route('enterprise.activity.index', $enterprise) )
    @breadcrumb_item(__('addworking.enterprise.enterprise_activity.create.create')."|active")
@endsection

@section('form')
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') {{ __('addworking.enterprise.enterprise_activity.create.general_information') }}</legend>

        {{ $activity->views->form }}
    </fieldset>

    <div class="text-right my-5">
        @button(__('addworking.enterprise.enterprise_activity.create.create_company')."|type:submit|color:success|shadow|icon:check")
    </div>
@endsection

@push('scripts')
    <script>
        $('input[name=representative],input[name=job_title],input[name=activity]').blur(function() {
            $(this).val($(this).val().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            }));
        });
    </script>
@endpush

