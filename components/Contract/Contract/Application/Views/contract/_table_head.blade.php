@th(__('components.contract.contract.application.views.contract._table_head.number')."|not_allowed")
@th(__('components.contract.contract.application.views.contract._table_head.name')."|not_allowed")
@if (! Auth::user()->isSupport())
    @th(__('components.contract.contract.application.views.contract._table_head.created_by')."|not_allowed")
@else
    @th(__('components.contract.contract.application.views.contract._table_head.model')."|not_allowed")
@endif
@th(__('components.contract.contract.application.views.contract._table_head.enterprise')."|not_allowed")
@th(__('components.contract.contract.application.views.contract._table_head.parties')."|not_allowed")
@th(__('components.contract.contract.application.views.contract._table_head.state')."|not_allowed")
@if (! Auth::user()->isSupport())
    @th(__('components.contract.contract.application.views.contract._table_head.amount')."|not_allowed")
@endif
@th(__('components.contract.contract.application.views.contract._table_head.valid_from')."|not_allowed")
@th(__('components.contract.contract.application.views.contract._table_head.valid_until')."|not_allowed")
@th(__('components.contract.contract.application.views.contract._table_head.actions')."|not_allowed|class:text-right")
