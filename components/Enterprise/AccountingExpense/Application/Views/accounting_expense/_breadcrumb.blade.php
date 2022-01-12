@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('accounting_expense::accounting_expense._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('accounting_expense::accounting_expense._breadcrumb.enterprises')."|href:".route('enterprise.index'))
        @breadcrumb_item("{$enterprise->name}|href:".route('enterprise.show', $enterprise))
        @breadcrumb_item(__('accounting_expense::accounting_expense._breadcrumb.index')."|href:".route('addworking.enterprise.accounting_expense.index', $enterprise))
        @breadcrumb_item(__('accounting_expense::accounting_expense._breadcrumb.create')."|active")
    @break

    @case('edit')
        @breadcrumb_item(__('accounting_expense::accounting_expense._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('accounting_expense::accounting_expense._breadcrumb.enterprises')."|href:".route('enterprise.index'))
        @breadcrumb_item("{$enterprise->name}|href:".route('enterprise.show', $enterprise))
        @breadcrumb_item(__('accounting_expense::accounting_expense._breadcrumb.index')."|href:".route('addworking.enterprise.accounting_expense.index', $enterprise))
        @breadcrumb_item(__('accounting_expense::accounting_expense._breadcrumb.show', ["number" => $accounting_expense->getNumber()])."|active")
        @breadcrumb_item(__('accounting_expense::accounting_expense._breadcrumb.edit')."|active")
    @break

    @default
        @breadcrumb_item(__('accounting_expense::accounting_expense._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('accounting_expense::accounting_expense._breadcrumb.enterprises')."|href:".route('enterprise.index'))
        @breadcrumb_item("{$enterprise->name}|href:".route('enterprise.show', $enterprise))
        @breadcrumb_item(__('accounting_expense::accounting_expense._breadcrumb.index')."|active")
@endswitch
