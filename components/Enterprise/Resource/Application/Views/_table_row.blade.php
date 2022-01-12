<tr>
    <td > {{ $resource->getLastName() }} </td>
    <td > {{ $resource->getFirstName() }} </td>
    <td > {{ $resource->getEmail() }} </td>
    <td class="text-center">
        @include('resource::_status')
    </td>
    <td class="text-right">
        @include('resource::_actions')
    </td>
</tr>
