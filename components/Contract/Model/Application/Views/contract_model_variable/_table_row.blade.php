<tr>
    <td>{{ $contract_model_variable->getName() }}</td>
    <td>{{ $contract_model_variable->getDisplayName() }}</td>
    <td>{{ $contract_model_variable->getContractModelParty()->getDenomination() }}</td>
    <td>{{ $contract_model_variable->getContractModelPart()->getDisplayName() }}</td>
    <td>{{ $contract_model_variable->getDescription() }}</td>
    <td>@if(strlen($contract_model_variable->getDefaultValue()) > 50) {{ substr($contract_model_variable->getDefaultValue(), 0, 50).'...'}} @else {{ $contract_model_variable->getDefaultValue() }} @endif</td>
    <td>@bool($contract_model_variable->getRequired())</td>
    <td>{{ $contract_model_variable->getInputType() }}</td>
</tr>

