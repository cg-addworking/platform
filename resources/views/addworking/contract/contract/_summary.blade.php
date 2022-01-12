<ol class="mb-0">
    <li class="@if($contract->file->exists) text-success @else text-muted @endif">
        {{ __('addworking.contract.contract._summary.contract_created') }}
    </li>

    <li class="@if(count($contract->contractParties) >= 2) text-success @else text-muted @endif">
        {{ __('addworking.contract.contract._summary.contract_with_atleast_2_stakeholders') }}
    </li>

    <li class="@if($contract->contractParties->every(fn($p) => $p->user->exists)) text-success @else text-muted @endif">
        {{ __('addworking.contract.contract._summary.signatories_assigned') }}
    </li>

    <li class="@if($contract->contractDocuments->contains(fn($d) => Repository::enterpriseDocument()->isValid($d->document))) text-success @else text-muted @endif">
        {{ __('addworking.contract.contract._summary.required_documents_valid') }}
    </li>

    <li class="@if($contract->contractParties->every(fn($p) => $p->hasSigned())) text-success @else text-muted @endif">
        {{ __('addworking.contract.contract._summary.signatories_signed') }}
    </li>

    <li class="@if(Repository::contract()->isPositiveStatus($contract)) text-success @elseif(Repository::contract()->isNegativeStatus($contract)) text-danger @elseif(Repository::contract()->isNeutralStatus($contract)) text-muted @endif">
        {{ __('addworking.contract.contract._summary.contract_is') }}{{ Repository::contract()->getStatus($contract, true) }}
    </li>
</ol>
