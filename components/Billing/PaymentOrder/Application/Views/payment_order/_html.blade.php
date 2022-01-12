<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.number'), 'icon' => "info"])
                    {{ $payment_order->getNumber() }}
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.status'), 'icon' => "info"])
                    @include('payment_order::payment_order._status')
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.executed_at'), 'icon' => "calendar"])
                    @date($payment_order->getExecutedAt())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.count_items'), 'icon' => "info"])
                    {{ $payment_order->getItems()->count() ?? 'n/a' }}
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.total_amount'), 'icon' => "info"])
                    @money($payment_order->getTotalAmount())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.customer'), 'icon' => "info"])
                    {{ $payment_order->getCustomerName() }}
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.debtor_info'), 'icon' => "info"])
                    <p>
                        {{ $payment_order->getDebtorName() }}<br>
                        <b>Libellé: </b>{{ $payment_order->iban->formatted_label }}<br>
                        <b>IBAN: </b>{{ $payment_order->getDebtorIban() }}<br>
                        <b>BIC: </b>{{ $payment_order->getDebtorBic() }}
                    </p>
                @endcomponent
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.file'), 'icon' => "info"])
                    @if($file = $payment_order->getFile())
                        <a href="{{ $file->routes->download }}">{{ __('addworking.components.billing.outbound.payment_order.html.download') }}</a>
                    @else
                        n/a
                    @endif
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.reference'), 'icon' => "info"])
                    {{ $payment_order->getReference() }}
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.bank_reference'), 'icon' => "info"])
                    {{ $payment_order->getBankReferencePayment() ?? 'n/a' }}
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.outbound_invoice'), 'icon' => "info"])
                    <ul>
                    @forelse ( $outbound_invoices as $outbound_invoice )
                        <li>
                            <a target="_blank" href="{{ route('addworking.billing.outbound.show', [$outbound_invoice->getEnterprise(), $outbound_invoice]) }}">
                                {{ $outbound_invoice->getFormattedNumber() }}
                            </a>
                        </li>
                    @empty
                        N/A
                    @endforelse
                    </ul>
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.created_at'), 'icon' => "calendar"])
                    @date($payment_order->getCreatedAt())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.updated_at'), 'icon' => "calendar"])
                    @date($payment_order->getUpdatedAt())
                @endcomponent

                @if (! is_null($payment_order->getDeletedAt()))
                    @component('bootstrap::attribute', ['label' => __('addworking.components.billing.outbound.payment_order.html.deleted_at'), 'icon' => "calendar"])
                        @date($payment_order->getDeletedAt())
                    @endcomponent
                @endif
                @component('bootstrap::attribute', ['label' => "UUID", 'icon' => "hashtag"])
                    <span class="clipboard" style="font-family: monospace" data-clipboard-text="{{ $payment_order->getId() }}" title="Copier dans le presse-papier" data-toggle="tooltip">{{ $payment_order->getId() }}</span>
                @endcomponent
            </div>
        </div>
    </div>
</div>
