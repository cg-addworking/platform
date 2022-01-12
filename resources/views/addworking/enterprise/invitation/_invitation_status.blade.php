<span class="badge badge-pill badge-{{ array_combine(invitation()::getAvailableStatuses(), ['warning', 'success', 'primary', 'danger'])[$invitation->status] }}">
    {{ invitation()::getAvailableStatuses(true)[$invitation->status] }}
</span>
