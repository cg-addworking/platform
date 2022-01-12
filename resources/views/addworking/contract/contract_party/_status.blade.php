@if($contract_party->needsSignatory())
    @can('assignSignatory', $contract_party)
        <a href="{{ $contract_party->routes->assign_signatory }}">
            {{ __('addworking.contract.contract_party._status.assign_signer') }}
        </a>
    @else
        <span class="text-muted">
            {{ __('addworking.contract.contract_party._status.must_assign_signer') }}
        </span>
    @endcan
@elseif($contract_party->hasSigned())
    <span class="text-success" @if($contract_party->signed_at) title="{{ __('addworking.contract.contract_party._status.at') }} @date($contract_party->signed_at)" @endif>
        @icon('check') {{ __('addworking.contract.contract_party._status.sign') }}
    </span>
@elseif($contract_party->hasDeclined())
    <span class="text-danger" @if($contract_party->declined_at) title="{{ __('addworking.contract.contract_party._status.at') }} @date($contract_party->declined_at)" @endif>
        @icon('times') {{ __('addworking.contract.contract_party._status.decline') }}
    </span>
@elseif($contract_party->needsToSign())
    <span class="text-success">@icon('file-signature') {{ __('addworking.contract.contract_party._status.must_sign') }}</span>
@elseif($contract_party->isWaitingToSign())
    <span class="text-muted">{{ __('addworking.contract.contract_party._status.waiting') }}</span>
@else
    <span class="text-warning">{{ __('addworking.contract.contract_party._status.status_unknown') }}</span>
@endif
