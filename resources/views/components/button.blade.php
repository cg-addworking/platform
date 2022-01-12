<a href="{{ $link ?? '#' }}" class="{{ $class ?? 'btn btn-primary center-block' }} {{ ($disabled ?? false) ? 'disabled' : '' }}">
	<i class="{{ $icon ?? '' }}"></i> &nbsp;&nbsp;
	{{ $icon_text ?? ''}}
</a>
