<td>{{ $mission_tracking_line->label }}</td>
<td class="text-right">@money($mission_tracking_line->amount)</td>
<td class="text-center">@bool($mission_tracking_line->validation_customer) @bool($mission_tracking_line->validation_vendor)</td>
<td class="text-right">{{ $mission_tracking_line->views->actions }}</td>
