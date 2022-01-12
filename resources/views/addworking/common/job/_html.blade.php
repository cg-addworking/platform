<div class="row">
    @attribute($job.'|class:col-md-4|icon:info|label:'.__('addworking.common.job._html.last_name'))
    @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "link"])
        @slot('label')
            {{ __('addworking.common.job._html.parent') }}
        @endslot

        @if($job->parent->exists)
            <a href="{{ route('addworking.common.enterprise.job.show', [$job->parent->enterprise, $job->parent]) }}">{{ $job->parent->display_name }}</a>
        @else
            n/a
        @endif
    @endcomponent

    @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "building"])
        @slot('label')
            {{ __('addworking.common.job._html.owner') }}
        @endslot

        @if($job->enterprise->exists)
            <a href="{{ route('enterprise.show', $job->enterprise) }}">{{ $job->enterprise->name }}</a>
        @else
            n/a
        @endif
    @endcomponent
</div>

<div class="row">
    @component('bootstrap::attribute', ['class' => "col-md-12", 'icon' => "comment-alt"])
        @slot('label')
            {{ __('addworking.common.job._html.description') }}
        @endslot

        {{ $job->description }}
    @endcomponent
</div>

<div class="row">
    @component('bootstrap::attribute', ['class' => "col-md-12", 'icon' => "info"])
        @slot('label')
            {{ __('addworking.common.job._html.skills') }}
        @endslot

        <ul>
            @foreach ($job->skills as $skill)
                <li>{{ $skill->views->link }}</li>
            @endforeach
        </ul>
    @endcomponent
</div>
