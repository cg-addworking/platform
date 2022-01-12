<tr>
    <td>{{ substr($contract_model_part->getId(), 0, 8) }}</td>
    <td>{{ $contract_model_part->getDisplayName() }}</td>
    <td>{{ $contract_model_part->getOrder() }}</td>
    <td>@bool($contract_model_part->getIsInitialled())</td>
    <td>@bool($contract_model_part->getIsSigned())</td>
    <td class="text-right">
        @include('contract_model::contract_model_part._actions')
    </td>
</tr>