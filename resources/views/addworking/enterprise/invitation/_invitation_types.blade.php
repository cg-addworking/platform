<span class="badge badge-pill badge-{{ array_combine(invitation()::getAvailableTypes(), ['info', 'secondary', 'warning'])[$invitation->type] }}">
    {{ invitation()::getAvailableTypes(true)[$invitation->type] }}
</span>
