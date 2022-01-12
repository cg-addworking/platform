@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_variable._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_variable._breadcrumb.index')."|href:".route('support.contract.model.index'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_variable._breadcrumb.show', ['number' => $contract_model->getNumber()])."|href:".route('support.contract.model.show',$contract_model))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_variable._breadcrumb.variables')."|active")
    @break

    @case('edit')
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_variable._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_variable._breadcrumb.index')."|href:".route('support.contract.model.index'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_variable._breadcrumb.show', ['number' => $contract_model->getNumber()])."|href:".route('support.contract.model.show',$contract_model))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_variable._breadcrumb.variables')."|href:".route('support.contract.model.variable.index', $contract_model))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_variable._breadcrumb.edit')."|active")
    @break

    @default
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_variable._breadcrumb.dashboard')."|href:".route('dashboard'))
@endswitch
