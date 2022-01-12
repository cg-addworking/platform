<li class="breadcrumb-item @if (isset($active) && $active) active @endif">
    @empty($active)
        @isset($model)
            {{ $model->views->link }}
        @else
            <a href="{{ $href ?? '#' }}">{{ $text ?? $slot ?? 'n/a' }}</a>
        @endif
    @else
        {{ $text ?? $slot ?? 'n/a' }}
    @endif
</li>
