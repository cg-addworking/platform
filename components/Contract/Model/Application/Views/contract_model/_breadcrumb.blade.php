@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.index')."|active")
    @break

    @case('create')
        @breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.index')."|href:".route('support.contract.model.index'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.create')."|active")
    @break

    @case('show')
        @breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.index')."|href:".route('support.contract.model.index'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.show', ['number' => $contract_model->getNumber()])."|active")
    @break

    @case('edit')
        @breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.index')."|href:".route('support.contract.model.index'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.show', ['number' => $contract_model->getNumber()])."|href:".route('support.contract.model.show', $contract_model))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.edit')."|active")
    @break

    @default
        @breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.dashboard')."|href:".route('dashboard'))
@endswitch
