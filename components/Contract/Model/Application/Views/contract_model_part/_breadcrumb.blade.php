
@breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.dashboard')."|href:".route('dashboard'))
@breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.index')."|href:".route('support.contract.model.index'))
@breadcrumb_item(__('components.contract.model.application.views.contract_model._breadcrumb.show', ['number' => $contract_model->getNumber()])."|href:".route('support.contract.model.show', $contract_model))

@switch($page ?? 'index')
    @case('index')
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_part._breadcrumb.index')."|active")
    @break

    @case('create')
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_part._breadcrumb.index')."|href:".route('support.contract.model.part.index', $contract_model))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_part._breadcrumb.create')."|active")
    @break

    @case('edit')
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_part._breadcrumb.index')."|href:".route('support.contract.model.part.index', $contract_model))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_part._breadcrumb.show', ['number' => $contract_model_part->getOrder()])."|href:#")
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_part._breadcrumb.edit')."|active")
    @break

    @default
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_part._breadcrumb.dashboard')."|href:".route('dashboard'))
@endswitch
