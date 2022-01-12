@if ($model instanceof Illuminate\Database\Eloquent\Model && $model->exists)
    {{-- we MUST use HasAttribute::getAttributeValue here because some classes may have relationships or method for those attributes names (like File::name() for instance) --}}
    <a href="{{ isset($model->routes->show) ? $model->routes->show : '#' }}">
        @if (isset($child))
            {{ $child }}
        @else
            @foreach ([$property ?? '', 'display_name', 'name', 'label'] as $key)
                @if (!empty($model->getAttributeValue($key)))
                    {{ $model->getAttributeValue($key) }}
                    @break
                @endif

                @if ($loop->last)
                    {{ substr($model->id, 0, 8) }}
                @endif
            @endforeach
        @endif
    </a>
@else
    <span class="text-muted">n/a</span>
@endif
