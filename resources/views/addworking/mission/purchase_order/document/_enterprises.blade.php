@push('styles')
    <style>
        /*ENTERPRISES*/
        .enterprises {
            margin-top: 140px;
        }

        .enterprises-customer-title, .enterprises-customer-address, .enterprises-vendor-title {
            font-weight: bold;
            font-size: 14px;
            font-style: italic;
        }

        .enterprises-customer-details {
            border: 2px solid black;
            height: 80px;
            padding-left: 10px;
            border-radius: 10px;
            margin-right: 10px;
        }


        .enterprises-customer-legal-representative > .legal-representative {
            font-weight: bold;
        }

        .enterprises-customer-details > .name {
            padding-top: 10px;
            font-weight: bold;
        }

        .enterprises-customer-details > .address {
            padding-top: 10px;
        }

        .enterprise-customer-payment {
            border: 2px solid black;
            height: 20px;
            padding-left: 10px;
            border-radius: 10px;
            margin-right: 10px;
        }

        .enterprises-vendor-details {
            border: 2px solid black;
            height: 205px;
            padding-left: 10px;
            border-radius: 10px;
            margin-left: 10px;
        }

        .enterprises-vendor-legal-representative {
            line-height: 20px;
        }

        .enterprises-vendor-address {
            padding-top: 40px;
            padding-bottom: 40px;
            margin-bottom: 40px;
        }

        .enterprises-vendor-phone-number {
            line-height: 120px;
        }

        .enterprises-vendor-email {
            line-height: 140px;
        }

        .enterprises-vendor-legal-representative > .legal-representative,
        .enterprises-vendor-address > .address,
        .enterprises-vendor-phone-number > .phone-number,
        .enterprises-vendor-email > .email
        {
            font-weight: bold;
        }
    </style>
@endpush

<div class="enterprises clearfix">
    <div class="left">
        <div class="enterprises-customer-title text-center">
            {{ __('addworking.mission.purchase_order.document._enterprises.buyer') }}
        </div>
        <div class="enterprises-customer-details">
            <table border="0" cellspacing="0" width="100%">
                <tr>
                    <td style="vertical-align: top; font-weight: bold;padding-top: 7px;">{{ __('addworking.mission.purchase_order.document._enterprises.last_name') }} :</td>
                    <td style="vertical-align: top; padding-top: 7px;">{{$mission->offer->createdBy->name}}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top; font-weight: bold;padding-top: 10px;">{{ __('addworking.mission.purchase_order.document._enterprises.legal_entity') }} :</td>
                    <td style="vertical-align: top; padding-top: 10px;">{{$mission->customer->name}}</td>
                </tr>
            </table>
        </div>

        <div class="enterprises-customer-address text-center">
            {{ __('addworking.mission.purchase_order.document._enterprises.billing_address') }}
        </div>
        <div class="enterprises-customer-details">
            <div class="text-center name">
                {{ __('addworking.mission.purchase_order.document._enterprises.addworking') }}
            </div>
            <div class="address">
                {!! __('addworking.mission.purchase_order.document._enterprises.address') !!}
            </div>
        </div>
        <div class="enterprise-customer-payment">
            <span class="">{{ __('addworking.mission.purchase_order.document._enterprises.payment_condition') }}:</span> {{ __('addworking.mission.purchase_order.document._enterprises.net_transfer') }} <!-- commentaire business : hardcodé pour le moment, mais à faire evoluer le moment venu -->
        </div>
    </div>

    <div class="right">
        <div class="enterprises-vendor-title text-center">
            {{ __('addworking.mission.purchase_order.document._enterprises.provider') }}
        </div>
        <div class="enterprises-vendor-details">
            <div class="enterprises-vendor-legal-representative">
                <div class="left legal-representative">{{ __('addworking.mission.purchase_order.document._enterprises.last_name') }} : </div>
                <div class="right">{{$mission->vendor->users->first()->name}}</div>
            </div>
            <div class="enterprises-vendor-address">
                <div class="left address">{{ __('addworking.mission.purchase_order.document._enterprises.address1') }} :</div>
                <div class="right">{{$mission->vendor->address->one_line}}</div>
            </div>
            <div class="enterprises-vendor-phone-number">
                <div class="left phone-number">{{ __('addworking.mission.purchase_order.document._enterprises.phone') }} :</div>
                <div class="right">{{$mission->vendor->phoneNumbers()->latest()->first()->number}}</div>
            </div>
            <div class="enterprises-vendor-email">
                <div class="left email">{{ __('addworking.mission.purchase_order.document._enterprises.mail') }} :</div>
                <div class="right">{{$mission->vendor->users->first()->email}}</div>
            </div>
        </div>
    </div>
</div>
