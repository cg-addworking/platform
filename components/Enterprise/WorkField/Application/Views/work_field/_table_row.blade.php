<tr>
    <td>@if(!is_null($work_field->getArchivedAt()))
            <span class="badge rounded-pill bg-warning text-dark">{{ __('work_field::workfield._table_row.archive') }}</span>
        @endif
        <a href="{{ route('work_field.show', $work_field) }}">{{ $work_field->getDisplayName() }}</a>
    </td>
    <td><a href="{{ route('enterprise.show', $work_field->getOwner()) }}">{{ $work_field->getOwner()->name }}</a></td>
    <td class="text-right">{{$work_field->getExternalId()}}</td>
    <td class="text-right">@money($work_field->getEstimatedBudget())</td>
    <td>@date($work_field->getStartedAt())</td>
    <td>@date($work_field->getEndedAt())</td>
    <td class="text-right">
        @include('work_field::work_field._actions_index')
    </td>
</tr>