<tr>
    <td><span class="clipboard" style="font-family: monospace" data-clipboard-text="{{ $invoiceParameter->getId() }}" title="Copier dans le presse-papier" data-toggle="tooltip">{{ substr($invoiceParameter->getId(), 0, 8) }}</span></td>
    <td>
        @date($invoiceParameter->getStartsAt())
    </td>
    <td>
        @date($invoiceParameter->getEndsAt())
    </td>
    <td class="text-center">
        @if($invoiceParameter->getDiscount() > 0 && $invoiceParameter->getDiscountEndsAt() > \Carbon\Carbon::now())
            <span class="badge badge-pill badge-success">{{ __('enterprise.invoiceParameter.application.views._table_row.yes') }}</span>
        @else
            <span class="badge badge-pill badge-danger">{{ __('enterprise.invoiceParameter.application.views._table_row.no') }}</span>
        @endif
    </td>
    <td class="text-center">
        @if($invoiceParameter->getDefaultManagementFeesByVendor() > 0)
            <span class="badge badge-pill badge-success">{{ __('enterprise.invoiceParameter.application.views._table_row.yes') }}</span>
        @else
            <span class="badge badge-pill badge-danger">{{ __('enterprise.invoiceParameter.application.views._table_row.no') }}</span>
        @endif
    </td>
    <td class="text-center">
        @if($invoiceParameter->getCustomManagementFeesByVendor() > 0)
            <span class="badge badge-pill badge-success">{{ __('enterprise.invoiceParameter.application.views._table_row.yes') }}</span>
        @else
            <span class="badge badge-pill badge-danger">{{ __('enterprise.invoiceParameter.application.views._table_row.no') }}</span>
        @endif
    </td>
    <td class="text-center">
        @if($invoiceParameter->getFixedFeesByVendor() > 0)
            <span class="badge badge-pill badge-success">{{ __('enterprise.invoiceParameter.application.views._table_row.yes') }}</span>
        @else
            <span class="badge badge-pill badge-danger">{{ __('enterprise.invoiceParameter.application.views._table_row.no') }}</span>
        @endif
    </td>
    <td class="text-center">
        @if($invoiceParameter->getSubscription() > 0)
            <span class="badge badge-pill badge-success">{{ __('enterprise.invoiceParameter.application.views._table_row.yes') }}</span>
        @else
            <span class="badge badge-pill badge-danger">{{ __('enterprise.invoiceParameter.application.views._table_row.no') }}</span>
        @endif
    </td>
    <td class="text-center">
        @if($invoiceParameter->getStatus())
            <span class="badge badge-pill badge-success">{{ __('enterprise.invoiceParameter.application.views._table_row.active') }}</span>
        @else
            <span class="badge badge-pill badge-danger">{{ __('enterprise.invoiceParameter.application.views._table_row.non_active') }}</span>
        @endif
    </td>
    <td class="text-right">
        @include('invoice_parameter::_actions')
    </td>
</tr>
