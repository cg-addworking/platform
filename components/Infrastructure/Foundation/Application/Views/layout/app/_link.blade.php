@if ($model instanceof Illuminate\Database\Eloquent\Model && $model->exists)
    {{-- we MUST use HasAttribute::getAttributeValue here because some classes may have relationships or method for those attributes names (like File::name() for instance) --}}
    <a href="{{ isset($model->routes->show) ? $model->routes->show : '#' }}">
        @if(isset($child))
            {{ $child }}
        @elseif(isset($property) && $model->getAttributeValue($property))
            {{ $model->getAttributeValue($property) }}
        @elseif($model->getAttributeValue('display_name'))
            {{ $model->getAttributeValue('display_name') }}
        @elseif($model->getAttributeValue('name'))
            {{ $model->getAttributeValue('name') }}
        @elseif($model->getAttributeValue('label'))
            {{ $model->getAttributeValue('label') }}
        @else
            {{ substr($model->id, 0, 8) }}
        @endif
    </a>
@else
    @include('foundation::layout.app._na')
@endif
