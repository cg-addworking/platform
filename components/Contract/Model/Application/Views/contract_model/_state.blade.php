@switch ($contract_model->getStatus())
    @case ($contract_model::STATUS_DRAFT)
        <span class="badge badge-pill badge-dark">{{ __("components.contract.model.application.views.contract_model._state.{$contract_model->getStatus()}") }}</span>
    @break
    @case ($contract_model::STATUS_PUBLISHED)
        <span class="badge badge-pill badge-success">{{ __("components.contract.model.application.views.contract_model._state.{$contract_model->getStatus()}") }}</span>
    @break
    @case ($contract_model::STATUS_ARCHIVED)
        <span class="badge badge-pill badge-primary">{{ __("components.contract.model.application.views.contract_model._state.{$contract_model->getStatus()}") }}</span>
    @break
@endswitch
