@if (($process = auth()->user()->current_onboarding_process) && $process->exists && $process->getCurrentStep()->fails())
    <div class="card">
        <div class="card-header">
            @icon('plane-departure|mr:2|color:muted') {{ __('addworking.user.dashboard._onboarding.boarding') }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ __("addworking.user.dashboard._onboarding.step.step") }} {{ $process->current_step + 1 }} {{ __("addworking.user.dashboard._onboarding.step.on") }} {{ count($process->steps) }}: {{ __("{$process->getCurrentStep()->description()}") }}</h5>
            <p class="card-text">{{ __("{$process->getCurrentStep()->message()}") }}</p>
            <a href="{{ $process->getCurrentStep()->action() }}" class="btn btn-primary">@icon('arrow-right|mr:2') {{ __("{$process->getCurrentStep()->callToAction()}") }}</a>
            <a href="#onboarding-process-steps" data-toggle="collapse" class="btn btn-secondary">@icon('list-ul|mr:2') {{ __("addworking.user.dashboard._onboarding.step.steps") }}</a>
        </div>
        <ul id="onboarding-process-steps" class="list-group list-group-flush collapse">
            @foreach ($process->steps as $i => $step)
                <li class="@if ($i <= $process->current_step) bg-success text-white @endif list-group-item">{{ $step->description() }}</li>
            @endforeach
        </ul>
    </div>
@endif
