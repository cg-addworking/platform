@inject('contractPartyRepository', 'Components\Contract\Contract\Application\Repositories\ContractPartyRepository')
@inject('contractRepository', 'Components\Contract\Contract\Application\Repositories\ContractRepository')
@inject('userRepository', 'Components\Contract\Contract\Application\Repositories\UserRepository')

@switch ($contract->getState())
    @case ($contract::STATE_DRAFT)
        <span class="badge badge-pill badge-dark">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
    @case ($contract::STATE_TO_COMPLETE)
        <span class="badge badge-pill badge-info">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
    @case ($contract::STATE_IN_PREPARATION)
        <span class="badge badge-pill badge-info">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
    @case ($contract::STATE_MISSING_DOCUMENTS)
        <span class="badge badge-pill badge-info">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
    @case ($contract::STATE_TO_SIGN)
    <span class="badge badge-pill badge-primary">{{ __("components.contract.contract.application.views.contract._state.{$contractRepository->getContractFacadeState($contract, $userRepository->connectedUser())}") }}</span>
    @break
    @case ($contract::STATE_TO_VALIDATE)
    <span class="badge badge-pill badge-primary">{{ __("components.contract.contract.application.views.contract._state.{$contractRepository->getContractFacadeState($contract, $userRepository->connectedUser())}") }}</span>
    @break
    @case ($contract::STATE_GENERATED)
        <span class="badge badge-pill badge-primary">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
    @case ($contract::STATE_IS_READY_TO_GENERATE)
        <span class="badge badge-pill badge-primary">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
    @case ($contract::STATE_GENERATING)
    <span class="badge badge-pill badge-primary">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
    @case ($contract::STATE_DECLINED)
        <span class="badge badge-pill badge-warning">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
    @case ($contract::STATE_SIGNED)
        <span class="badge badge-pill badge-success">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
    @case ($contract::STATE_ACTIVE)
        <span class="badge badge-pill badge-success">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
        @if(!$contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($contract))
            @icon('exclamation-triangle|mr:3|color:danger')
        @endif
    @break
    @case ($contract::STATE_DUE)
        <span class="badge badge-pill badge-danger">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
    @case ($contract::STATE_INACTIVE)
        <span class="badge badge-pill badge-warning">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
    @case ($contract::STATE_CANCELED)
        <span class="badge badge-pill badge-warning">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
    @case ($contract::STATE_UNKNOWN)
        <span class="badge badge-pill badge-dark">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
    @case ($contract::STATE_ARCHIVED)
        <span class="badge badge-pill badge-secondary">{{ __("components.contract.contract.application.views.contract._state.{$contract->getState()}") }}</span>
    @break
@endswitch
