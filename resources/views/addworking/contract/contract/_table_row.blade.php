<tr>
    <td>{{ $contract->views->link }}</td>
    <td>{{ $contract->contractTemplate->views->link }}</td>
    <td>
        @foreach($contract->contractParties as $party)
            {{ $party->enterprise->views->link }}
            @if (! $loop->last) , @endif
        @endforeach
    </td>
    <td>@date($contract->valid_until)</td>
    <td>{{ $contract->views->status }}</td>
    <td class="text-right">{{ $contract->views->actions }}</td>
</tr>
