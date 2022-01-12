@push('styles')
    <style>
        /*DETAILS*/
        .details {
            margin-top: 20px;
        }
    </style>
@endpush

<div class="details clearfix">
    <table border="1" cellspacing="0" width="100%">
        <tr>
            <th>{{ __('addworking.mission.purchase_order.document._details.assignment_purpose') }}</th>
            <th>{{ __('addworking.mission.purchase_order.document._details.amount') }}</th>
            <th>{{ __('addworking.mission.purchase_order.document._details.unit') }}</th>
            <th>{{ __('addworking.mission.purchase_order.document._details.uht_price') }}</th>
            <th>{{ __('addworking.mission.purchase_order.document._details.uht_amount') }}</th>
        </tr>
        <tr>
            <td>{{$mission->offer->label}}</td>
            <td>{{$mission->quantity}}</td>
            <td>@lang("mission.mission.unit_{$mission->unit}")</td>
            <td>{{$mission->unit_price}}</td>
            <td>{{$mission->amount}}</td>
        </tr>
    </table>
</div>
