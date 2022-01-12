<div class="card shadow">
    <div class="card-body">
        @component('bootstrap::attribute', ['label' => __('billing.outbound.application.views._html.amount_excluding_taxes'), 'icon' => "credit-card"])
            @money($outboundInvoice->getAmountBeforeTaxes())
        @endcomponent

        @component('bootstrap::attribute', ['label' => __('billing.outbound.application.views._html.vat_amount'), 'icon' => "credit-card"])
            @money($outboundInvoice->getAmountOfTaxes())
        @endcomponent

        @component('bootstrap::attribute', ['label' => __('billing.outbound.application.views._html.amount_including_taxes'), 'icon' => "credit-card"])
            <b>@money($outboundInvoice->getAmountAllTaxesIncluded())</b>
        @endcomponent
    </div>
</div>

<div class="card shadow mt-2">
    <div class="card-body">
        @attribute("{$outboundInvoice->getEnterprise()->name}|icon:user|label:".__('billing.outbound.application.views._html.client'))

        @component('bootstrap::attribute', ['label' => __('billing.outbound.application.views._html.status'), 'icon' => "info"])
            @include('outbound_invoice::_status')
        @endcomponent

        @attribute("{$outboundInvoice->getFormattedNumber()}|label:". __('billing.outbound.application.views._html.number') ."|icon:hashtag")

        @component('bootstrap::attribute', ['label' => __('billing.outbound.application.views._html.period'), 'icon' => "calendar-check"])
            {{ $outboundInvoice->getMonth() }}
        @endcomponent

        @component('bootstrap::attribute', ['label' => __('billing.outbound.application.views._html.issue_date'), 'icon' => "calendar"])
            @date($outboundInvoice->getInvoicedAt())
        @endcomponent

        @component('bootstrap::attribute', ['label' => __('billing.outbound.application.views._html.payment_order_date'), 'icon' => "calendar"])
            <ul>
            @forelse ($payment_orders as $payment_order)
                <li>
                    @support()
                        <a target="_blank" href="{{ route('addworking.billing.payment_order.show', [$outboundInvoice->getEnterprise(), $payment_order])}}">
                    @endsupport
                    {{ $payment_order->getNumber() }} - @date($payment_order->getExecutedAt())
                    @support()
                        </a>
                    @endsupport
                </li>
            @empty
                N/A
            @endforelse
            </ul>
        @endcomponent

        @component('bootstrap::attribute', ['label' => __('billing.outbound.application.views._html.due_date'), 'icon' => "calendar"])
            @date($outboundInvoice->getDueAt()) ({{ $outboundInvoice->getDeadline()->display_name ?? 'n/a' }})
        @endcomponent

        @component('bootstrap::attribute', ['label' => __('billing.outbound.application.views._html.legal_notice'), 'icon' => "calendar"])
            @if(! is_null($outboundInvoice->getLegalNotice()))<p>{{ $outboundInvoice->getLegalNotice() }}</p>@endif
            @if($outboundInvoice->getReverseChargeVat())<p>{{ __('billing.outbound.application.views._html.reverse_vat') }}</p>@endif
            @if($outboundInvoice->getDaillyAssignment())<p>{{ __('billing.outbound.application.views._html.received_by_assignment_daily') }}</p>@endif
        @endcomponent

        @support
            @component('bootstrap::attribute', ['label' => __('billing.outbound.application.views._html.uuid'), 'icon' => "hashtag"])
                <span class="clipboard" style="font-family: monospace" data-clipboard-text="{{ $outboundInvoice->getId() }}" title="{{ __('billing.outbound.application.views._html.copy_to_clipboard') }}" data-toggle="tooltip">{{ $outboundInvoice->getId() }}</span>
            @endcomponent
            @if ($outboundInvoice->getParent()->exists)
                @component('bootstrap::attribute', ['label' => __('billing.outbound.application.views._html.parent_invoice_number'), 'icon' => "id-card-alt"])
                    <a href="{{ route('addworking.billing.outbound.show', [$enterprise, $outboundInvoice->getParent()]) }}">
                    {{ $outboundInvoice->getParent()->getFormattedNumber() }}
                    </a>
                @endcomponent
            @endif
            @attribute("{$outboundInvoice->created_at}|icon:calendar-plus|label:". __('billing.outbound.application.views._html.created_date'))
            @attribute("{$outboundInvoice->updated_at}|icon:calendar-check|label:". __('billing.outbound.application.views._html.last_modified_date'))
            @if(! is_null($outboundInvoice->getUpdatedBy()))
                @attribute("{$outboundInvoice->getUpdatedBy()->getNameAttribute()}|icon:edit|label:". __('billing.outbound.application.views._html.updated_by'))
            @endif

            @if(! is_null($outboundInvoice->getValidatedBy()))
                @attribute("{$outboundInvoice->getValidatedBy()->getNameAttribute()}|icon:info|label:". __('billing.outbound.application.views._html.validated_by'))
            @endif

            @if (! is_null($outboundInvoice->getValidatedAt()))
                @component('bootstrap::attribute', ['icon' => "info", 'color' => "primary", 'label' => __('billing.outbound.application.views._html.validated_at')])
                    @date($outboundInvoice->getValidatedAt())
                @endcomponent
            @endif
        @endsupport
    </div>
</div>