<tr>
    <td>@date($response->getCreatedAt())</td>
    <td><a href="{{ route('enterprise.show', $response->getEnterprise()) }}" target="_blank">{{ $response->getEnterprise()->name }}</a>
    <td>@money($response->getAmountBeforeTaxes())</td>
    <td>@include('offer::response._status')</td>
    <td class="text-right">
        @include('offer::response._actions_index')
    </td>
</tr>
