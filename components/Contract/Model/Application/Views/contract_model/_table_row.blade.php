<tr>
    <td>{{ $contract_model->getNumber() }}</td>
    <td> @include('contract_model::contract_model._state')</td>
    <td>{{ $contract_model->getEnterprise()->views->link ?? 'n/a' }}</td>
    <td><a href="{{ route('support.contract.model.show', $contract_model) }}">{{ $contract_model->getDisplayName() }}</a></td>
    <td class="text-right">
        @include('contract_model::contract_model._actions')
    </td>
</tr>