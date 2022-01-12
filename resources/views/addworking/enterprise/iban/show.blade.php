@extends('foundation::layout.app.show')

@section('title', __('addworking.enterprise.iban.show.title'). $iban->enterprise->name)

@section('toolbar')
    {{ $iban->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.iban.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.iban.show.company_iban')." {$iban->enterprise->name}|active")
@endsection

@section('content')
    <div class="row mb-4">
        @if ($iban->isPending())
            <div class="col-md-12">
                <div class="alert alert-warning mt-3" role="alert">
                    <strong>{{ __('addworking.enterprise.iban.show.iban_awaiting_confirmation') }} : </strong>
                    {{ __('addworking.enterprise.iban.show.check_mailbox') }}
                    <a href="{{ route('enterprise.iban.resend', ['enterprise' => $enterprise, 'iban' => $iban]) }}">
                        {{ __('addworking.enterprise.iban.show.resend_confirmation_email') }}
                    </a>.
                </div>
            </div>
        @else
            @isset($iban->label)
                @component('bootstrap::attribute', ['class' => "col-md-6", 'label' => __('addworking.enterprise.iban.show.label')])
                    {{ $iban->label }}
                @endcomponent
            @endisset
            @component('bootstrap::attribute', ['class' => "col-md-6", 'label' => "IBAN"])
                {{ $iban->iban }}
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'label' => "BIC"])
                {{ $iban->bic }}
            @endcomponent
        @endif
    </div>
@endsection
