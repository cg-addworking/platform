<div class="{{ $class_box ?? 'col-md-3 col-sm-6' }}">
    <a href="{{ $link ?? '#' }}" class="{{ $class ?? 'detail_link' }} {{ ($disabled ?? false) ? 'disabled' : '' }}">
        <div class="bloc">
            <p class="number">{{ $number ?? "" }}</p>
            <p class="status">{!! $content ?? "" !!}</p>
            <div class="rounded_arrow">
                <i class="fa fa-arrow-right"></i>
            </div>
        </div>
    </a>
</div>
