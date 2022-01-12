@php
$pageWidth  = 725;
$pageHeight = 945;
@endphp
<div style="min-width: {{ (int) ($width ?? $pageWidth) }}px; max-width: {{ (int) ($width ?? $pageWidth) }}px; width: {{ (int) ($width ?? $pageWidth) }}px; min-height: {{ (int) ($height ?? $pageHeight) }}px; max-height: {{ (int) ($height ?? $pageHeight) }}px; height: {{ (int) ($height ?? $pageHeight) }}px; overflow: hidden; {{ $style ?? '' }}">
    @if ($header ?? false)
        <div style="min-height: {{ $header_height ?? 0 }}px; max-height: {{ $header_height ?? 0 }}px; height: {{ $header_height ?? 0 }}px; overflow: hidden">
            {{ $header }}
        </div>
    @endif

    <div style="min-height: {{ (int) ($height ?? $pageHeight) - (int) ($header_height ?? 0) - (int) ($footer_height ?? 0) }}px; max-height: {{ (int) ($height ?? $pageHeight) - (int) ($header_height ?? 0) - (int) ($footer_height ?? 0) }}px; height: {{ (int) ($height ?? $pageHeight) - (int) ($header_height ?? 0) - (int) ($footer_height ?? 0) }}px; overflow: hidden">
        {{ $slot }}
    </div>

    @if ($footer ?? false)
        <div style="min-height: {{ $footer_height ?? 0 }}px; max-height: {{ $footer_height ?? 0 }}px; height: {{ $footer_height ?? 0 }}px; overflow: hidden">
            {{ $footer }}
        </div>
    @endif
</div>
