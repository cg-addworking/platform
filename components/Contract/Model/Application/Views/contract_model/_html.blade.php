@inject('contractModelDocumentTypeRepository', 'Components\Contract\Model\Application\Repositories\ContractModelDocumentTypeRepository')

<div class="row">
    <div class="col-md-8">
        @component('bootstrap::attribute', ['label' => __('components.contract.model.application.views.contract_model._html.display_name'), 'icon' => "tag"])
            <div class="ml-3">{{ $contract_model->getDisplayName() . " " .__('components.contract.model.application.views.contract_model._html.version', ['version_number' => $contract_model->getVersion()]) }}</div>
        @endcomponent
        @attribute("{$contract_model->getEnterprise()->name}|icon:building|label:".__('components.contract.model.application.views.contract_model._html.enterprise'))

        @component('bootstrap::attribute', ['label' => __('components.contract.model.application.views.contract_model._html.parties'), 'icon' => "handshake"])
            <ul>
            @forelse($contract_model->getParties()->sortBy('order') as $contract_model_party)
                <li>
                    {{ $contract_model_party->getDenomination() }}
                    @can('delete', [$contract_model_party, $contract_model])
                        -
                        @if($loop->count > 2)
                            <a class="text-danger ml-3" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                                {{ __('components.contract.model.application.views.contract_model._html.delete') }}
                            </a>
                            @push('forms')
                                <form name="{{ $name }}" action="{{ route('support.contract.model.party.delete', [$contract_model, $contract_model_party]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            @endpush
                        @endif
                    @endcan
                    @can('index', [get_class($contractModelDocumentTypeRepository->make()), $contract_model_party])
                        -
                        <a href="{{ route('support.contract.model.party.document_type.index', [$contract_model, $contract_model_party]) }}">
                            {{ __('components.contract.model.application.views.contract_model._html.document_types') }}
                        </a>
                    @endcan
                </li>
            @empty
                <li>n/a</li>
            @endforelse
            </ul>
        @endcomponent

        @attribute(($contract_model->getPublishedAt() ?? 'N/A')."|icon:calendar-check|label:".__('components.contract.model.application.views.contract_model._html.published_date'))
        @attribute(($contract_model->getArchivedAt() ?? 'N/A')."|icon:calendar-check|label:".__('components.contract.model.application.views.contract_model._html.archived_date'))
    </div>
    <div class="col-md-4">
        @attribute("{$contract_model->getId()}|icon:id-card-alt|label:".__('components.contract.model.application.views.contract_model._html.id'))
        @attribute("{$contract_model->getCreatedAt()}|icon:calendar-plus|label:".__('components.contract.model.application.views.contract_model._html.created_date'))
        @attribute("{$contract_model->getUpdatedAt()}|icon:calendar-check|label:".__('components.contract.model.application.views.contract_model._html.last_modified_date'))
        @component('bootstrap::attribute', ['label' => __('components.contract.model.application.views.contract_model._html.should_vendors_fill_their_variables')])
            <div class="ml-3">
                @if($contract_model->getShouldVendorsFillTheirVariables())
                    <span class="badge badge-pill badge-success">{{ __('components.contract.model.application.views.contract_model._html.yes') }}</span>
                @else
                    <span class="badge badge-pill badge-danger">{{ __('components.contract.model.application.views.contract_model._html.no') }}</span>
                @endif
            </div>
        @endcomponent
        @component('bootstrap::attribute', ['label' => __('components.contract.model.application.views.contract_model._html.status')])
                            <div class="ml-3">@include('contract_model::contract_model._state')</div>
         @endcomponent
    </div>
</div>
