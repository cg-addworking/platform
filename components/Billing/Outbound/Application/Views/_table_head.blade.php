@if (auth()->user()->isSupport())
    <th class="text-center">{{ __('billing.outbound.application.views._table_head.customer_visibility') }}</th>
@endif
@th(__('billing.outbound.application.views._table_head.bill_number')."|column:number")
@th(__('billing.outbound.application.views._table_head.invoiced_at')."|column:invoiced_at|class:text-center")
@th(__('billing.outbound.application.views._table_head.due_at')."|column:due_at|class:text-center")
@th(__('billing.outbound.application.views._table_head.month')."|column:month|class:text-center")
@th(__('billing.outbound.application.views._table_head.deadline')."|column:deadline|class:text-center")
@th(__('billing.outbound.application.views._table_head.amount_ht')."|not_allowed|class:text-center")
@th(__('billing.outbound.application.views._table_head.tax')."|not_allowed|class:text-center")
@th(__('billing.outbound.application.views._table_head.total')."|not_allowed|class:text-center")
@th(__('billing.outbound.application.views._table_head.status')."|column:status|class:text-center")
@th(__('billing.outbound.application.views._table_head.action')."|not_allowed|class:text-center")