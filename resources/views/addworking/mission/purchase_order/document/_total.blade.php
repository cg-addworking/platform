@push('styles')
    <style>
        /*TOTAL*/
        .total-ht {
            border: 2px solid black;
            margin-top: 20px;
            height: 20px;
        }

        .tva {
            border: 2px solid black;
            border-top: none;
            border-bottom: none;
            height: 20px;
        }

        .total-ttc {
            border: 2px solid black;
            border-top: none;
            margin-top: -10px;
            height: 10px;
        }

        .total-ht, .tva, .total-ttc {
            padding : 5px;
        }

        .total-ht > .right, .tva > .right, .total-ttc > .right {
            color: #ff0000;
        }
    </style>
@endpush

<div class="total-ht clearfix">
    <div class="left">
        {{ __('addworking.mission.purchase_order.document._total.total_net_excl_tax') }}
    </div>
    <div class="right text-right">
        {{ number_format($mission->amount, 2, '.', ' ') }}
    </div>
</div>
<div class="tva clearfix">
    <div class="left">
        {{ __('addworking.mission.purchase_order.document._total.vat') }}
    </div>
    <div class="right text-right">
        {{ number_format($mission->customer->vat_rate * $mission->amount, 2, '.', ' ') }}
    </div>
</div>
<div class="total-ttc clearfix">
    <div class="left">
        {{ __('addworking.mission.purchase_order.document._total.total_price') }}
    </div>
    <div class="right text-right">{{ number_format($mission->amount + $mission->amount * $mission->customer->vat_rate, 2, '.', ' ') }}</div>
</div>
