{{ $enterprise_activity->activity }}<br>
<small class="text-muted">{{ $enterprise_activity->field }}</small>
<p>
    @lang('enterprise.enterprise_activity.employees_in_region', [
        'count'  => $enterprise_activity->employees_count,
        'region' => $enterprise_activity->region,
    ])
</p>
