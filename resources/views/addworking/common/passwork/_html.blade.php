<div class="row">
    @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "building"])
        @slot('label')
            {{ __('addworking.common.passwork._html.owner') }}
        @endslot

        @if($passwork->user->exists)
            <a href="{{ route('user.show', $passwork->user) }}">{{ $passwork->user->name }}</a>
        @elseif ($passwork->vendor->exists)
            <a href="{{ route('enterprise.show', $passwork->vendor) }}">{{ $passwork->vendor->name }}</a>
        @else
            n/a
        @endif
    @endcomponent

    @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "building"])
        @slot('label')
            {{ __('addworking.common.passwork._html.client') }}
        @endslot

        @if($passwork->customer->exists)
            <a href="{{ route('enterprise.show', $passwork->customer) }}">{{ $passwork->customer->name }}</a>
        @else
            n/a
        @endif
    @endcomponent
</div>

<div class="row">
    @component('bootstrap::attribute', ['class' => "col-md-12", 'icon' => "info"])
        @slot('label')
            {{ __('addworking.common.passwork._html.skills') }}
        @endslot

        <ul>
            @foreach ($passwork->skills as $skill)
                <li><a href="{{ route('addworking.common.enterprise.job.skill.show', [$skill->job->enterprise, $skill->job, $skill]) }}">{{ $skill->display_name }}: {{ $skill->pivot->level }}</a></li>
            @endforeach
        </ul>
    @endcomponent
</div>
