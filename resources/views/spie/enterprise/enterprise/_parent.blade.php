@if ($enterprise->enterprise->parent->exists)
    <a href="{{ $enterprise->enterprise->parent->routes->show }}">{{ $enterprise->enterprise->parent->name }}</a>
@else
    <small class="text-muted">n/a</small>
@endif
