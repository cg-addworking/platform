<div style="border-bottom: dotted 1px #dedede" class="{{ $class ?? 'mb-1' }}">
    <span class="text-muted"><i class="mr-2 fa fa-fw fa-{{ $icon ?? 'info' }}"></i> {{ ucfirst($name ?? 'n/a') }}</span> <span class="pull-right">{{ !empty($sensitive) ? sensitive_data($slot) : $slot }}</span>
</div>
