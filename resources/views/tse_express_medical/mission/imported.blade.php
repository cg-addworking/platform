@extends('layouts.app')

@section('id', 'tse-express-medical-mission-import')

@section('title')

    <div class="row">
        <div class="col-md-12">
            @component('components.panel')
                <h1 class="mb-0">{{ __('tse_express_medical.mission.imported.import_mission') }}</h1>
            @endcomponent
        </div>
    </div>

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            @if (!empty($errors))
                @component('components.panel', ['class' => "danger", 'icon' => "exclamation-triangle", 'collapse' => true, 'collapsed' => true])
                    @slot('heading')
                        Errors ({{ count($errors) }})
                    @endslot

                    @foreach ($errors as list($item, $error))
                        <h3>{{ $error->getMessage() }}</h3>
                        <pre>{{ json_encode($item, JSON_PRETTY_PRINT) }}</pre>

                        @if (config('app.env') == 'local')
                            <h5>Stack</h5>
                            <pre>{{ $error->getTraceAsString() }}</pre>
                        @endif

                        @unless ($loop->last)
                            <hr>
                        @endunless
                    @endforeach
                @endcomponent
            @endif

            @component('components.panel')
                @slot('heading')
                    {{ __('tse_express_medical.mission.imported.new_missions') }} ({{ count($missions) }})
                @endslot

                @forelse ($missions as $mission)
                    {{ $mission->views->link }}<br>
                @empty
                    <h3>{{ __('tse_express_medical.mission.imported.no_mission_imported') }}</h3>
                @endforelse
            @endcomponent
        </div>
    </div>

@endsection
