<tr>
    <td>{{ $accounting_expense->getDisplayName() }}</td>
    <td >{{ $accounting_expense->getAnalyticalCode() }}</td>
    <td class="text-right">
        @include('accounting_expense::accounting_expense._actions')
    </td>
</tr>
