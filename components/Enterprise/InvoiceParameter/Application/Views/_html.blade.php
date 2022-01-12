<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.enterprise'), 'icon' => "building"])
                    {{ $invoiceParameter->getEnterprise()->name ?? 'n/a' }}
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.starts_at_date'), 'icon' => "calendar"])
                    @date($invoiceParameter->getStartsAt())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.ends_at_date'), 'icon' => "calendar"])
                    @date($invoiceParameter->getEndsAt())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.iban'), 'icon' => "money-check-alt"])
                    {{ $invoiceParameter->getIban()->iban ?? 'n/a' }} @isset($invoiceParameter->getIban()->bic) (BIC: {{ $invoiceParameter->getIban()->bic }}) @endisset
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.invoicing_from_inbound_invoice'), 'icon' => "file-invoice"])
                    @if($invoiceParameter->getInvoicingFromInboundInvoice())
                        <span class="badge badge-pill badge-success">{{ __('enterprise.invoiceParameter.application.views._html.yes') }}</span>
                    @else
                        <span class="badge badge-pill badge-danger">{{ __('enterprise.invoiceParameter.application.views._html.no') }}</span>
                    @endif
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.vendor_creating_inbound_invoice_items'), 'icon' => "file-invoice"])
                    @if($invoiceParameter->getVendorCreatingInboundInvoiceItems())
                        <span class="badge badge-pill badge-success">{{ __('enterprise.invoiceParameter.application.views._html.yes') }}</span>
                    @else
                        <span class="badge badge-pill badge-danger">{{ __('enterprise.invoiceParameter.application.views._html.no') }}</span>
                    @endif
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.subscription'), 'icon' => "money-bill"])
                    @money($invoiceParameter->getSubscription())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.fixed_cost'), 'icon' => "money-bill"])
                    @money($invoiceParameter->getFixedFeesByVendor())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.management_rate'), 'icon' => "percentage"])
                    @percentage($invoiceParameter->getDefaultManagementFeesByVendor())
                @endcomponent
                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.management_rate_by_service_provider'), 'icon' => "percentage"])
                    @percentage($invoiceParameter->getCustomManagementFeesByVendor())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.discount'), 'icon' => "sort-amount-down"])
                    @money($invoiceParameter->getDiscount())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.discount_start_date'), 'icon' => "calendar"])
                    @date($invoiceParameter->getDiscountStartsAt())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.discount_end_rate'), 'icon' => "calendar"])
                    @date($invoiceParameter->getDiscountEndsAt())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.deadlines_by_default'), 'icon' => "info"])
                    {{ implode(' ,', $deadlines) }}
                @endcomponent

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.uuid'), 'icon' => "hashtag"])
                    <span class="clipboard" style="font-family: monospace" data-clipboard-text="{{ $invoiceParameter->getId() }}" title={{ __('enterprise.invoiceParameter.application.views._html.copy_to_clipboard') }} data-toggle="tooltip">{{ $invoiceParameter->getId() }}</span>
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.status'), 'icon' => "eye"])
                    @if($invoiceParameter->getStatus())
                        <span class="badge badge-pill badge-success">{{ __('enterprise.invoiceParameter.application.views._html.active') }}</span>
                    @else
                        <span class="badge badge-pill badge-danger">{{ __('enterprise.invoiceParameter.application.views._html.non_active') }}</span>
                    @endif
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.analytical_code'), 'icon' => "info"])
                    {{ $invoiceParameter->getAnalyticCode() ?? 'n/a' }}
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.billing_floor'), 'icon' => "file-invoice-dollar"])
                    @money($invoiceParameter->getBillingFloorAmount())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.billing_cap'), 'icon' => "file-invoice-dollar"])
                    @money($invoiceParameter->getBillingCapAmount())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.created_date'), 'icon' => "calendar"])
                    @date($invoiceParameter->getCreatedAt())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.last_modification_date'), 'icon' => "calendar"])
                    @date($invoiceParameter->getUpdatedAt())
                @endcomponent

                @component('bootstrap::attribute', ['label' => __('enterprise.invoiceParameter.application.views._html.deleted_date'), 'icon' => "calendar"])
                    @date($invoiceParameter->getDeletedAt())
                @endcomponent

            </div>
        </div>
    </div>
</div>