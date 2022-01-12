<div id="{{ $id = $id ?? uniqid() }}" class="panel panel-{{ $class ?? 'default' }}{{ isset($height) ? " panel-fixed-height-{$height}" : "" }}{{ isset($pull) ? " pull-{$pull}" : "" }}">
    @if (!empty($heading))
        <div class="panel-heading">
            @if ($icon ?? false)
                <i class="text-{{ ($class ?? 'default') == 'default' ? 'muted' : $class }} mr-2 fa fa-fw fa-{{ $icon }}"></i>
            @endif

            <b>{{ $heading }}</b>

            @if ($collapse ?? false)
                <a href="#" class="pull-right" data-toggle="collapse" data-target="#{{ $id }} .panel-body">
                    <i class="fa fa-fw fa-caret-{{ ($collapsed ?? false) ? 'right' : 'down' }} text-{{ $class ?? 'default' }}"></i>
                </a>
            @endif
        </div>
    @endif

    @if ($body ?? true)
        <div class="panel-body {{ ($collapse ?? false) ? (($collapsed ?? false) ? 'collapse' : 'collapse in') : '' }}">
            {{ $slot }}
        </div>
    @endif

    @if (!empty($table))
        {{ $table }}
    @endif

    @if (!empty($list))
        {{ $list }}
    @endif

    @if (!empty($footer))
        <div class="panel-footer">
            {{ $footer }}
        </div>
    @endif
</div>
