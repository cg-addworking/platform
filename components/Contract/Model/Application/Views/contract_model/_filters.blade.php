@inject('contract_model', 'Components\Contract\Model\Application\Repositories\ContractModelRepository')

<div class="row" role="filter">
    <div class="col-md-3">
        @form_group([
            'text'     => __('components.contract.model.application.views.contract_model._filters.enterprise'),
            'type'     => "select",
            'name'     => "filter.enterprises.",
            'options'  => $enterprises_with_model,
            'value'    => request()->input('filter.enterprises'),
            'multiple' => true,
            'selectpicker' => true,
        ])
    </div>

    <div class="col-md-3 hide">
        @form_group([
            'text'     => __('components.contract.model.application.views.contract_model._filters.status'),
            'type'     => "select",
            'name'     => "filter.statuses.",
            'options'  => $contract_model->getAvailableStatuses(true),
            'value'    => request()->input('filter.statuses'),
            'multiple' => true,
            'selectpicker' => true,
        ])
    </div>

    <div class="col-md-3">
        @form_group([
            'text' => __('components.contract.model.application.views.contract_model._filters.archived_contract_model'),
            'type' => "select",
            'name' => "filter.archived_contract_model",
            'value' => request()->input('filter.archived_contract_model') ?? "0",
            'options' => ["0" => "Non",  "1" => "Oui"],
        ])
    </div>

    <div class="col-md-12 mt-2 mb-2 text-right">
        <button type="submit" class="btn btn-outline-primary mr-2 rounded">@icon('check') {{ __('addworking.components.billing.inbound.index.filters.filter') }}</button>
        @if (array_filter((array) request()->input('filter', [])))
            <a href="?reset" class="btn btn-outline-danger mr-2 rounded">@icon('times') {{ __('addworking.components.billing.inbound.index.filters.reset') }}</a>
        @endif
    </div>
</div>