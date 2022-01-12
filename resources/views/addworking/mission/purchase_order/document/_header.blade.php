@push('styles')
    <style>
        /*HEADER*/
        .header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 200px;
        }

        .header-title {
            height: 140px;
        }

        .header-customer{
            float: left;
            width: 40%;
            font-size: 20px;
            vertical-align: middle;
            display: inline-block;
        }

        .header-purchase-order {
            margin-top: 30px;
            display: inline-block;
            height: 120px;
            float: right;
            vertical-align: middle;
            width: 50%;
        }

        .header-reference {
            font-weight: bold;
            color: #ff0000;
        }

        .logo-everial {
            padding-top: 40px;
        }

        .logo-spga {
            padding-top: 10px;
        }
    </style>
@endpush

<div class="header">
    <div class="header-title">
        <div class="header-customer text-center">
                @if($mission->customer->name == "EVERIAL")
                    <img class="logo-everial" src="img/logo_everial.png" alt="EVERIAL Logo">
                @elseif($mission->customer->name == "SPGA - SOCIETE PARTENAIRE DE GESTION D'ARCHIVES")
                    <img class="logo-spga" src="img/logo_spga.png" alt="SPGA Logo" width="50%">
                @else
                    {{$mission->customer->name}}
                @endif
        </div>

        <div class="header-purchase-order text-center">
            <h3>{{ __('addworking.mission.purchase_order.document._header.purchase_order') }}</h3>
            {{ __('addworking.mission.purchase_order.document._header.created') }} {{carbon()->now()->format('d/m/Y')}}
        </div>
    </div>

    <span class="header-reference">{{ __('addworking.mission.purchase_order.document._header.reference_mission') }} : {{$mission->number}}</span><br/>
    {{-- {{ __('addworking.mission.purchase_order.document._header.reference_mission') }} --}}
    {!! __('addworking.mission.purchase_order.document._header.remind_correspondence') !!}
</div>
