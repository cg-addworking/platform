<a href="{{ $href ?? '#' }}" class="{{ $class ?? '' }}" target="{{ $target ?? '' }}" title="{{ $title ?? '' }}">
    @if (isset($icon))
        <i class="fa fa-{{ $icon }}"></i>
    @endif

    {{ $slot }}
</a>
