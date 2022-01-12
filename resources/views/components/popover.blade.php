<a href="#" data-toggle="popover" data-html="true" data-placement="{{ $placement ?? 'bottom' }}" data-content="{!! htmlspecialchars($slot) !!}" title="{{ $title ?? '' }}">
    {{ $label ?? '' }}
</a>
