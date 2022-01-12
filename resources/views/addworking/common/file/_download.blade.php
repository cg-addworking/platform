@if ($file->exists)
    <a href="{{ $file->routes->download }}">@icon('download') {{ (string) $file }}</a>
@else
    n/a
@endif
