@foreach(user()::getAvailableRoles(true) as $role => $name)
    @if ($user->hasRoleFor($enterprise, $role))
        <span class="badge badge-pill badge-{{ $role == 'is_admin' ? 'warning' : 'primary' }}">
            {{ $name }}
        </span>
    @endif
@endforeach
