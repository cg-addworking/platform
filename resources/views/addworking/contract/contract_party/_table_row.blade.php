<tr>
    <td>
        @if($contract_party->order)
            {{ $contract_party->order }}
        @else
            <small class="text-muted">n/a</small>
        @endif
    </td>
    <td>
        @if($contract_party->denomination)
            {{ $contract_party->denomination }}
        @else
            <small class="text-muted">n/a</small>
        @endif
    </td>
    <td>{{ $contract_party->views->signatory }}</td>
    <td class="text-center">
        <a href="{{ $contract_party->contractPartyDocumentTypes()->make()->routes->index }}">
            {{ count($contract_party->contractPartyDocumentTypes) }}
        </a>
    </td>
    <td>{{ $contract_party->views->status }}</td>
    <td class="text-right">{{ $contract_party->views->actions }}</td>
</tr>
