@push('styles')
    <style>
        /*SHIPPING INFORMATIONS*/
        .shipping-informations{
            margin-top: 20px;
            border: 2px solid black;
            height: 150px;
            border-radius: 10px;
            padding: 10px;
        }

        .shipping-informations-title{
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .shipping-informations-referent{
            margin-bottom: 10px;
        }

        .shipping-informations-note{
            margin-top: 10px;
        }
    </style>
@endpush

<div class="shipping-informations clearfix">
    <div class="shipping-informations-title text-center">
        {{ __('addworking.mission.purchase_order.document._shipping_informations.delivery_information') }}
    </div>
    <div class="shipping-informations-referent text-center">
        <strong>{{ __('addworking.mission.purchase_order.document._shipping_informations.referent') }} :</strong> {{$mission->offer->referent->name}}
    </div>

    <div class="left">
        <strong>{{ __('addworking.mission.purchase_order.document._shipping_informations.shipping_site') }} : </strong> {{$mission->offer->everialReferentialMissions->first()->shipping_site}}<br>
        {{$mission->offer->everialReferentialMissions->first()->shipping_address}}
    </div>
    <div class="right">
        <strong>{{ __('addworking.mission.purchase_order.document._shipping_informations.destination_site') }} : </strong> {{$mission->offer->everialReferentialMissions->first()->destination_site}}<br>
        {{$mission->offer->everialReferentialMissions->first()->destination_address}}
    </div>

    <div style="margin-top:10px; margin-bottom:10px">
        <strong>{{ __('addworking.mission.purchase_order.document._shipping_informations.expected_start_date') }} :</strong> @date($mission->starts_at)
    </div>

    <div style="margin-bottom:10px">
        <strong>{{ __('addworking.mission.purchase_order.document._shipping_informations.description') }} :</strong> {{$mission->description}}
    </div>
</div>
<div class="shipping-informations-note">
    {{ __('addworking.mission.purchase_order.document._shipping_informations.by_receiving_supplier_undertakes') }} :<br/>{{ __('addworking.mission.purchase_order.document._shipping_informations.supplier_undertake_1') }}<br/>{{ __('addworking.mission.purchase_order.document._shipping_informations.supplier_undertake_2') }}<br/>{{ __('addworking.mission.purchase_order.document._shipping_informations.supplier_undertake_3') }}<br/>
</div>
