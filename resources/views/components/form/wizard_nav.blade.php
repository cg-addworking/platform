<li class="{{ ($active ?? false) ? 'active' : '' }} {{ ($disabled ?? false) ? 'disabled' : '' }}">
    <a href="#{{ $target }}" data-toggle="wizard" aria-controls="{{ $target }}">
        <h4 class="list-group-item-heading{{ empty($description) ? ' mb-0' : '' }}">{{ $slot }}</h4>
        @if (! empty($description))
            <p class="list-group-item-text">{{ $description }}</p>
        @endif
    </a>
</li>
