@inject('inboundInvoiceRepository', 'App\Repositories\Addworking\Billing\InboundInvoiceRepository')

<div class="card shadow">
    <div class="card-body">
        @component('bootstrap::attribute', ['label' => __('addworking.billing.inbound_invoice._html.amount_excluding_taxes'), 'icon' => "credit-card"])
            @money($inbound_invoice->amount_before_taxes)
        @endcomponent

        @component('bootstrap::attribute', ['label' => __('addworking.billing.inbound_invoice._html.amount_of_taxes'), 'icon' => "credit-card"])
            @money($inbound_invoice->amount_of_taxes)
        @endcomponent

        @component('bootstrap::attribute', ['label' => __('addworking.billing.inbound_invoice._html.amount_all_taxes_included'), 'icon' => "credit-card"])
            @money($inbound_invoice->amount_all_taxes_included)
        @endcomponent
    </div>
</div>

<div class="card shadow mt-2">
    <div class="card-body">
        @component('bootstrap::attribute', ['label' => __('addworking.billing.inbound_invoice._html.service_provider'), 'icon' => "users"])
            <b>{{ $inbound_invoice->enterprise->name }}</b> pour le client <b>{{ $inbound_invoice->customer->name }}</b>
        @endcomponent

        @component('bootstrap::attribute', ['label' => __('addworking.billing.inbound_invoice._html.status'), 'icon' => "info"])
            @include('addworking.billing.inbound_invoice._status')
                @if(! is_null($inboundInvoiceRepository->getPaymentOrderOfInboundInvoice($inbound_invoice)))
                    @support()
                        <a target="_blank" href="{{ route('addworking.billing.payment_order.show', [$inbound_invoice->outboundInvoice->getEnterprise(), $inboundInvoiceRepository->getPaymentOrderOfInboundInvoice($inbound_invoice)])}}">
                    @endsupport
                        le @date($inboundInvoiceRepository->getPaymentOrderOfInboundInvoice($inbound_invoice)->getExecutedAt())
                    @support()
                        </a>
                    @endsupport
                @endif
        @endcomponent

        @attribute("{$inbound_invoice->number}|label: ".__('addworking.billing.inbound_invoice._html.number') ."|icon:hashtag")

        @component('bootstrap::attribute', ['label' => __('addworking.billing.inbound_invoice._html.date_of_invoice'), 'icon' => "calendar"])
            @date($inbound_invoice->invoiced_at) ( {{ $inbound_invoice->deadline()->first()->display_name ?? 'n/a' }} )
        @endcomponent

        @component('bootstrap::attribute', ['label' => __('addworking.billing.inbound_invoice._html.period'), 'icon' => "calendar-check"])
            @if(app()->getLocale() == 'de')
                {{ month_de((int) substr($inbound_invoice->month, 0, 2)) }} {{ substr($inbound_invoice->month, -4) }}
            @else
                {{ month_fr((int) substr($inbound_invoice->month, 0, 2)) }} {{ substr($inbound_invoice->month, -4) }}
            @endif
        @endcomponent

        @component('bootstrap::attribute', ['label' => __('addworking.billing.inbound_invoice._html.is_factoring'), 'icon' => "money-check"])
            @if($inbound_invoice->is_factoring)
                <span class="badge badge-pill badge-success">{{ __('addworking.billing.inbound_invoice._html.yes') }}</span>
            @else
                <span class="badge badge-pill badge-danger">{{ __('addworking.billing.inbound_invoice._html.no') }}</span>
            @endif
        @endcomponent

        @component('bootstrap::attribute', ['label' => __('addworking.billing.inbound_invoice._html.note'), 'icon' => "id-card-alt"])
            {{ $inbound_invoice->note ?? 'n/a' }}
        @endcomponent
    </div>
</div>

<div class="card shadow mt-2">
    <div class="card-body">
        @support()
            @component('bootstrap::attribute', ['label' => __('addworking.billing.inbound_invoice._html.administrative_compliance'), 'icon' => "info"])
                {{array_get(inbound_invoice()::getAvailableComplianceStatuses(true), $inbound_invoice->compliance_status)}}
            @endcomponent

            @component('bootstrap::attribute', ['label' => __('addworking.billing.inbound_invoice._html.associated_customer_invoice'), 'icon' => "info"])
                @if ($inbound_invoice->outboundInvoice->exists)
                    <a href="{{ route('addworking.billing.outbound.show', [$inbound_invoice->outboundInvoice->getEnterprise(), $inbound_invoice->outboundInvoice->getId()]) }}" target="_blank">
                        {{ $inbound_invoice->outboundInvoice->getFormattedNumber() }}
                    </a>
                @else
                    n/a
                @endif
            @endcomponent

            @component('bootstrap::attribute', ['label' => __('addworking.billing.inbound_invoice._html.admin_amount'), 'icon' => "info"])
                HT : @money($inbound_invoice->admin_amount) |
                TVA : @money($inbound_invoice->admin_amount_of_taxes) |
                TTC : @money($inbound_invoice->admin_amount_all_taxes_included)
            @endcomponent

            @component('bootstrap::attribute', ['label' => "UUID", 'icon' => "hashtag"])
                <span class="clipboard" style="font-family: monospace" data-clipboard-text="{{ $inbound_invoice->id }}" title="Copier dans le presse-papier" data-toggle="tooltip">{{ $inbound_invoice->id }}</span>
            @endcomponent
        @endsupport

        @attribute("{$inbound_invoice->created_at}|icon:calendar-plus|label: ".__('addworking.billing.inbound_invoice._html.creation_date'))
    </div>
</div>

@if(!$inbound_invoice->actions->isEmpty())
<div class="card shadow mt-2">
    <div class="card-body">
        @component('bootstrap::attribute', ['label' => __('addworking.billing.inbound_invoice._html.tracking'), 'icon' => "users"])
            <ul>
            @foreach($inbound_invoice->actions->sortByDesc('created_at') as $action)
                <li>{{ $action->getmessage() }}</li>
            @endforeach
            </ul>
        @endcomponent
    </div>
</div>
@endif

@if (!$inbound_invoice->customer->isBusinessPlus())
    <div class="card shadow mt-2">
        <div class="card-body">
            {{ $inbound_invoice->comments }}
            @include('addworking.common.comment._create', ['item' => $inbound_invoice])
        </div>
    </div>
@endif