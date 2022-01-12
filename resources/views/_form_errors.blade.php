@if (count($errors))
    @component('components.panel', ['class' => "danger", 'icon' => "exclamation-triangle"])
        @slot('heading')
            Erreurs
        @endslot

        <ul class="mb-0 pl-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endcomponent
@endif
