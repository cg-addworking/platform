@extends('foundation::layout.app.index')

@section('title', 'Lignes de suivi')

@section('toolbar')
    @button("Export|href:".route('support.enterprise.mission.tracking.line.export')."?".http_build_query(request()->all())."|icon:download|color:primary|outline|sm|mr:2")
    @button("Import|href:".route('tracking_line.import')."|icon:upload|color:outline-primary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item("Tableau de bord|href:".route('dashboard'))
    @breadcrumb_item("Lignes de suivi|active")
@endsection

@section('table.head')
    @th("Prestataire|not_allowed")
    @th("Client|not_allowed")
    @th("N° mission|not_allowed")
    @th("Fin de période|not_allowed")
    @th("Décision du Prestataire|not_allowed")
    @th("Décision du Client|not_allowed")
    @th("Quantité|not_allowed")
    @th("Prix Unitaire|not_allowed")
    @th("Total|not_allowed")
    @th("Actions|not_allowed")
@endsection

@section('table.filter')
    <td>
        @component('bootstrap::form.control', [
            'type'  => "text",
            'name'  => "filter.vendor",
            'class' => "form-control-sm",
            'value' => request()->input('filter.vendor'),
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
            'type'  => "text",
            'name'  => "filter.customer",
            'class' => "form-control-sm",
            'value' => request()->input('filter.customer'),
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
            'type'  => "number",
            'name'  => "filter.mission",
            'class' => "form-control-sm",
            'value' => request()->input('filter.mission'),
            'step' => 1,
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
            'type'  => "select",
            'options' => [
                '01' => 'Janvier',
                '02' => 'Février',
                '03' => 'Mars',
                '04' => 'Avril',
                '05' => 'Mai',
                '06' => 'Juin',
                '07' => 'Juillet',
                '08' => 'Août',
                '09' => 'Septembre',
                '10' => 'Octobre',
                '11' => 'Novembre',
                '12' => 'Décembre'
            ],
            'value' => request()->input('filter.month'),
            'name'  => "filter.month",
            'class' => "form-control-sm"
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
          'type'    => "select",
          'options' => array_mirror(mission_tracking_line()::getAvailableStatuses()),
          'value'   => request()->input('filter.vendor_status'),
          'name'    => "filter.vendor_status",
          'class'   => "form-control-sm"
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
          'type'    => "select",
          'options' => array_mirror(mission_tracking_line()::getAvailableStatuses()),
          'value'   => request()->input('filter.customer_status'),
          'name'    => "filter.customer_status",
          'class'   => "form-control-sm"
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
            'type'  => "number",
            'name'  => "filter.quantity",
            'class' => "form-control-sm",
            'value' => request()->input('filter.quantity'),
        ])
        @endcomponent
    </td>
    <td></td>
    <td></td>
    <td><button class="btn btn-sm btn-primary btn-block" type="submit">@icon('check')</button></td>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')

    @forelse ($items as $line)
        @continue(is_null($line->missionTracking))
        <tr>
            <td>{{ $line->missionTracking->mission->vendor->views->link }}</td>
            <td>{{ $line->missionTracking->mission->customer->views->link }}</td>
            <td>
                @component('foundation::layout.app._link', ['model' => $line->missionTracking->mission, 'property' => 'number'])
                @endcomponent
            </td>
            <td>@date($line->missionTracking->milestone->ends_at)</td>
            <td class="text-center">
                @component('foundation::layout.app._link', ['model' => $line->missionTracking])
                    @slot('child')
                        @include('addworking.mission.mission_tracking_line._status', ['status' => $line->validation_vendor])
                    @endslot
                @endcomponent
            </td>
            <td class="text-center">
                @component('foundation::layout.app._link', ['model' => $line->missionTracking])
                    @slot('child')
                        @include('addworking.mission.mission_tracking_line._status', ['status' => $line->validation_customer])
                    @endslot
                @endcomponent
            </td>
            <td class="text-center">{{ $line->quantity }}</td>
            <td>{{$line->unit_price . "€"}}</td>
            <td>@money($line->quantity * $line->unit_price)</td>
            <td class="text-right">{{ $line->views->actions }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="99" class="text-center">
                <div class="p-5">
                    @icon('frown-open') Vide
                </div>
            </td>
        </tr>
    @endforelse
@endsection
