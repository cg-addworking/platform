<tr>
    <td>@date($offer->getCreatedAt())</td>
    <td>{{ $offer->getLabel() }}</td>
    <td>{{ $offer->getCustomer()->name }}</td>
    <td>{{ $offer->getReferent()->name }}</td>
    <td>@include('offer::offer._status')</td>
    <td class="text-right">
        @include('offer::offer._actions')
    </td>
</tr>
