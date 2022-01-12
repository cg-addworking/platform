@extends('foundation::layout.app.index')

@section('title', "Factures prestataires")

@section('toolbar')
    @button("Exporter|href:".route('support.billing.inbound_invoice.export')."?".http_build_query(request()->all())."|icon:file-export|color:primary|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item('Support|href:'.route('dashboard') )
    @breadcrumb_item("Factures prestataires|active")
@endsection

@section('table.colgroup')
    <col width="5%">
    <col width="20%">
    <col width="15%">
    <col width="5%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="5%">
@endsection

@section('table.head')
    @th("Date d’émission|column:created_at")
    @th("Prestataire|not_allowed")
    @th("Client|not_allowed")
    @th("Numéro|not_allowed")
    @th("Statut|not_allowed|class:text-center")
    @th("Montant HT|not_allowed|class:text-center")
    @th("Montant taxes|not_allowed|class:text-center")
    @th("Montant TTC|not_allowed|class:text-center")
    @th("Facture associée|not_allowed|class:text-center")
    @th("Action|not_allowed|class:text-right")
@endsection

@section('table.filter')
    <td>
        @form_control([
        'type'  => "date",
        'name'  => "filter[created_at]",
        'value' => request()->input('filter.created_at')
        ])
    </td>
    <td>
        @form_control([
        'type'  => "text",
        'name'  => "filter[enterprise]",
        'value' => request()->input('filter.enterprise')
        ])
    </td>
    <td>
        @form_control([
        'type'  => "text",
        'name'  => "filter[customer]",
        'value' => request()->input('filter.customer')
        ])
    </td>
    <td>
        @form_control([
        'type'  => "text",
        'name'  => "filter[number]",
        'value' => request()->input('filter.number')
        ])
    </td>
    <td>
        @form_control([
        'type'    => "select",
        'name'    => "filter[status]",
        'options' => inbound_invoice()::getAvailableStatuses(true),
        'value'   => request()->input('filter.status')
        ])
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>@button(['icon' => "check", 'type' => "sumbit"])</td>
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @forelse ($items as $invoice)
        <tr @if($invoice->customer->isBusinessPlus()) class="table-active" @endif>
            <td>@date($invoice->created_at)</td>
            <td>{{ $invoice->enterprise->views->link }}</td>
            <td>{{ $invoice->customer->views->link }}</td>
            <td>{{ $invoice->number }}</td>
            <td class="text-center">{{ $invoice->views->status }}
                @if($invoice->customer->isBusinessPlus()) <span class="badge badge-pill badge-warning">Business +</span> @endif
            </td>
            <td class="text-right">@money($invoice->amount_before_taxes)</td>
            <td class="text-right">@money($invoice->amount_of_taxes)</td>
            <td class="text-right">@money($invoice->amount_all_taxes_included)</td>
            <td>
                @if($invoice->outboundInvoice()->exists())
                    <a href="{{route('addworking.billing.outbound.show', [$invoice->customer, $invoice->outboundInvoice])}}">
                        {{ $invoice->outboundInvoice->number }}
                    </a>
                @else
                    N/A
                @endif
            </td>
            <td class="text-right">{{ $invoice->views->actions }}</td>
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
