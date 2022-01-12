@if(!$contract_party->user->exists)
    <small class="text-muted">n/a</small>
@else
    {{ $contract_party->user->views->link }} {{ __('addworking.contract.contract_party._signatory.for') }} {{ $contract_party->enterprise->views->link }}<br>
@endif
