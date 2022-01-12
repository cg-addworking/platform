@extends('foundation::layout.app.show')

@section('title', "Mission : {$referential->label}")

@section('toolbar')
    @button(__('everial.mission.referential.show.return')."|href:{$referential->routes->index}|icon:arrow-left|color:secondary|outline|sm|ml:2")
    {{ $referential->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('everial.mission.referential.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('everial.mission.referential.show.referential_missions').'|href:'.$referential->routes->index )
    @breadcrumb_item($referential->label ."|active")
@endsection

@section('tabs')
    <a class="nav-item nav-link active" id="nav-details-tab" data-toggle="tab" href="#nav-details" role="tab" aria-controls="nav-details" aria-selected="true">{{ __('everial.mission.referential.show.details') }}</a>
@endsection

@section('content')
    <div class="tab-pane fade show active" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">
        <div class="row mb-4">
            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "warehouse", 'label' => "Site d'expédition"])
                {{ optional($referential)->shipping_site  }}
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "warehouse", 'label' => 'Site destinataire'])
                {{ optional($referential)->destination_site }}
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "map-marked", 'label' => "Adresse d'expédition"])
                {{ optional($referential)->shipping_address }}
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "map-marked", 'label' => "Adresse destinataire"])
                {{ optional($referential)->destination_address }}
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "shipping-fast", 'label' => "Nombre de kilomètre(s)"])
                {{ optional($referential)->distance }} Km
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "pallet", 'label' => "Nombre de palettes ({$referential->pallet_type})"])
                {{ optional($referential)->pallet_number }}
            @endcomponent

            @support()
                @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "hashtag", 'label' => "Prestataire mieux-disant"])
                    {{ $referential->bestBidder->exists ? $referential->bestBidder->views->link : 'n/a' }}
                @endcomponent
            @endsupport

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "hashtag", 'label' => "Code analytique"])
                {{ optional($referential)->analytic_code }}
            @endcomponent
        </div>
    </div>
@endsection
