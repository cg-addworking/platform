<div class="btn-group">
    <button class="btn btn-{{ $class ?? 'default' }} btn-xs px-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-{{ $icon ?? 'angle-down' }}"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-right">
        {!! $slot !!}
    </ul>
</div>
