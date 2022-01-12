@foreach ($relations as $relation => $class)
    @php
        $tabs[snake_case($relation)] = [
            'name' => __("messages.relations.{$relation}"),
        ];

        // Use this check for temporary
        if ($relation != 'passwork') {
            $tabs[snake_case($relation)]['badge'] = $model->$relation()->count();
        }
    @endphp
@endforeach

@component('components.tabs', ['class' => "pills", 'tabs' => $tabs ?? []])
    @foreach ($relations as $relation => $class)
        {{-- Use this check for temporary --}}
        @if ($relation != 'passwork')
            @slot(snake_case($relation))
                @forelse (is_model($model->$relation) ? [$model->$relation] : $model->$relation as $item)
                    @component('components.panel', ['class' => "info", 'collapse' => true])
                        @slot('heading')
                            {{ str_max((string) $item, 96) }}
                        @endslot

                        {{ optional($item->views)->html }}
                    @endcomponent
                @empty
                    @component('components.panel')
                        @lang('messages.empty')
                    @endcomponent
                @endforelse
            @endslot
        @else
            @slot(snake_case($relation))
                @if ($model->hasPasswork() && is_model($model->$relation()))
                    {{ optional(optional($model->$relation()))->views->html }}
                @else
                    @component('components.panel')
                        @lang('messages.empty')
                    @endcomponent
                @endif
            @endslot
        @endif
    @endforeach
@endcomponent
