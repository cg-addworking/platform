<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="{{ $heading_id = uniqid() }}">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#{{ $accordion }}" href="#{{ $collapse_id = uniqid() }}"{{ $expanded ?? false ? ' aria-expanded="true"' :''}} aria-controls="{{ $collapse_id}}">
                {{ $title ?? $heading ?? '' }}
            </a>
        </h4>
    </div>
    <div id="{{ $collapse_id }}" class="panel-collapse collapse{{ $expanded ?? false ? ' in' : '' }}" role="tabpanel" aria-labelledby="{{ $heading_id }}">
        <div class="panel-body">
            {{ $slot }}
        </div>
    </div>
</div>
