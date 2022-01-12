<tr>
    <td > {{$activity_period->resource->enterprise->views->link}}</td>
    <td > {{ $activity_period->resource->getLastName() }} </td>
    <td > {{ $activity_period->resource->getFirstName() }} </td>
    <td > {{ $activity_period->resource->getEmail() }} </td>
    <td class="text-center"> @date($activity_period->getStartsAt()) </td>
    <td class="text-center"> @date($activity_period->getEndsAt()) </td>
    <td class="text-center">
        @include('resource::_status',['resource' => $activity_period->resource])
    </td>
    <td class="text-right">
        @include('resource::activity_period._actions',['resource' => $activity_period])
    </td>
</tr>
