<tr>
    <td>{{ $contract_variable->getContractModelVariable()->getContractModelPart()->getDisplayName() }}</td>
    <td>{{ optional(optional($contract_variable->getContractParty())->getEnterprise())->name ?? 'n/a'}}</td>
    <td>{{ $contract_variable->getContractModelVariable()->getDisplayName() ?? 'n/a'}}</td>
    <td>@if(strlen($contract_variable->getValue()) > 50) {{ substr($contract_variable->getValue(), 0, 50).'...'}} 
            @else {{ $contract_variable->getValue() ?? 'n/a' }} @endif </td>
    <td>@bool($contract_variable->getContractModelVariable()->getRequired())</td>
    <td>{{ $contract_variable->getContractModelVariable()->getDescription()}}</td>
</tr>