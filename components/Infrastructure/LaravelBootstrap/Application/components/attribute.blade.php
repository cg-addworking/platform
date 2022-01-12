<div @attr('attribute_attr')>
    <label class="font-weight-bold text-{{ $color ?? 'primary' }} border-bottom d-block">
        <span style="opacity: .4">@icon(($icon ?? 'info').'|color:'.($color ?? 'primary').'|ml-2')</span> {{ $label ?? '' }}
    </label>
    <p>{{ $text ?? $slot ?? '' }}</p>
</div>
