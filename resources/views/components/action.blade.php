<a href="{{ $href ?? '#' }}" class="btn btn-{{ $class ?? 'default' }} btn-block force-text-left" {{ attr($_attributes ?? []) }}>
    <i class="mr-2 ml-2 fa fa-{{ $icon ?? 'chevron-right' }} "></i> {{ $slot }}
</a>
