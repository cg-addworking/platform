@extends('foundation::layout.app.show')

@section('title', $enterprise->name)

@section('toolbar')
    @button(__('addworking.enterprise.enterprise.show.return')."|href:".route('enterprise.index')."|icon:arrow-left|color:secondary|outline|sm|ml:2|mr:2")

    @if($enterprise->company->exists)
        @button("Nouvelle fiche entreprise|href:".route('company.show', $enterprise->company)."|icon:building|color:primary|outline|sm|mr:2|target:_blank")
    @endif

    @can('synchronizeNavibat', $enterprise)
        @button("Synchronisation Navibat|href:".route('enterprise.synchronize-navibat', $enterprise)."|icon:sync|color:primary|outline|sm|ml:2|mr:2")
    @endcan

    {{ $enterprise->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.enterprise.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.enterprise.show.enterprise')."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|active")
@endsection

@section('tabs')
    <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{ __('addworking.enterprise.enterprise.show.general_information') }}</a>
    @can('viewPhoneNumbersInfo', $enterprise)
        <a class="nav-item nav-link" id="nav-phone-number-tab" data-toggle="tab" href="#nav-phone-number" role="tab" aria-controls="nav-phone-number" aria-selected="true">{{ __('addworking.enterprise.enterprise.show.phone_number') }}</a>
    @endcan
    @can('viewAnyVendor', $enterprise)
        <a class="nav-item nav-link" id="nav-vendor-tab" data-toggle="tab" href="#nav-vendor" role="tab" aria-controls="nav-vendor" aria-selected="true">{{ __('addworking.enterprise.enterprise.show.providers') }}</a>
    @endcan
    @can('showSogetrelData', $enterprise)
        <a class="nav-item nav-link" id="nav-sogetrel-metadata-tab" data-toggle="tab" href="#nav-sogetrel-metadata" role="tab" aria-controls="nav-sogetrel-metadata" aria-selected="true">{{ __('addworking.enterprise.enterprise.show.sogetrel_data') }}</a>
    @endcan
    @can('showBusinessTurnover', $enterprise)
        <a class="nav-item nav-link" id="nav-business-turnover-tab" data-toggle="tab" href="#nav-business-turnover" role="tab" aria-controls="nav-business-turnover" aria-selected="true">{{ __('addworking.enterprise.enterprise.show.business_turnover') }}</a>
    @endcan
@endsection

@section('content')
    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
        {{ $enterprise->views->html }}
    </div>

    @can('viewPhoneNumbersInfo', $enterprise)
        @include('addworking.enterprise.enterprise.tabs._phone_number', ['enterprise' => $enterprise])
    @endcan

    @can('viewAnyVendor', $enterprise)
        @include('addworking.enterprise.enterprise.tabs._vendor', ['enterprise' => $enterprise])
    @endcan

    @can('showSogetrelData', $enterprise)
        @include('addworking.enterprise.enterprise.tabs._sogetrel_data', ['enterprise' => $enterprise])
    @endcan

    @can('showBusinessTurnover', $enterprise)
        @include('addworking.enterprise.enterprise.tabs._business_turnover', ['enterprise' => $enterprise])
    @endcan
@endsection
