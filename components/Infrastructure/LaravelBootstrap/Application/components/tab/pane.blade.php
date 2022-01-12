<div class="tab-pane fade show @if(!empty($active)) active @endif" id="nav-{{ $name }}" role="tabpanel" aria-labelledby="nav-{{ $name }}-tab">
    {{ $text ?? $slot ?? 'n/a' }}
</div>
