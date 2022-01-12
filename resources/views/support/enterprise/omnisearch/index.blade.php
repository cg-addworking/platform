@extends('foundation::layout.app')

@section('main')
    @component("bootstrap::form", ['action' => route('support.enterprise.omnisearch.search'), 'method' => "post"])
        @form_group([
            'text'     => "Rechercher",
            'name'     => "search",
            'value'    => request()->input('search'),
            'required' => true,
        ])

        @button("Rechercher|icon:search")
    @endcomponent

    @foreach ($models ?? [] as $model)
        <div class="card mt-3">
            <div class="card-header">
                <div class="d-flex">
                    <div>{{ get_class($model) }}</div>
                    <div class="ml-auto clipboard" style="font-family: monospace" data-clipboard-text="{{ $model->id }}" title="Copier dans le presse-papier" data-toggle="tooltip">{{ substr($model->id, 0, 8) }}</div>
                </div>
            </div>
            <div class="card-body">
                {{ optional($model->views)->html }}

                <div class="text-right">
                @if (get_class($model) == user() && auth()->user()->can('impersonate', $model))
                    @button("Se Connecter|icon:magic|color:success|outline|href:" . route('impersonate', $model))
                @endif

                @button("Afficher|icon:search|color:secondary|outline|href:{$model->routes->show}")
                </div>
            </div>
        </div>
    @endforeach
@endsection
