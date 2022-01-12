@unless($destroy ?? false)
    <a class="dropdown-item" href="{{ $href ?? '#' }}">
        @icon(sprintf('%s|color:%s|mr:3', $icon ?? 'cog', $color ?? 'muted')) {{ $text ?? $slot ?? '' }}
    </a>
@else
    <a class="dropdown-item text-danger" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
        @icon(sprintf('%s|mr:3', $icon ?? 'trash')) {{ trans('foundation::actions.action_item.delete') }}
    </a>
    @push('modals')
        <form name="{{ $name }}" action="{{ $href ?? '' }}" method="post">
            @method('DELETE')
            @csrf
        </form>
    @endpush
@endunless
