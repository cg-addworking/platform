@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_document_type._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_document_type._breadcrumb.index')."|href:".route('support.contract.model.index'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_document_type._breadcrumb.show', ['number' => $contract_model->getNumber()])."|href:".route('support.contract.model.show', $contract_model))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_document_type._breadcrumb.party', ['number' => $contract_model_party->getOrder()])."|href:#")
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_document_type._breadcrumb.document_type')."|href:".route('support.contract.model.party.document_type.index', [$contract_model, $contract_model_party]))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_document_type._breadcrumb.create')."|active")
    @break

    @case('index')
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_document_type._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_document_type._breadcrumb.index')."|href:".route('support.contract.model.index'))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_document_type._breadcrumb.show', ['number' => $contract_model->getNumber()])."|href:".route('support.contract.model.show', $contract_model))
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_document_type._breadcrumb.party', ['number' => $contract_model_party->getOrder()])."|href:#")
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_document_type._breadcrumb.document_type')."|active")
    @break

    @default
        @breadcrumb_item(__('components.contract.model.application.views.contract_model_document_type._breadcrumb.dashboard')."|href:".route('dashboard'))
@endswitch
