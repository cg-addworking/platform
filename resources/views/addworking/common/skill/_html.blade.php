<div class="row">
    @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "info"])
        @slot('label')
            {{ __('addworking.common.skill._html.job') }}
        @endslot

        {{ $skill->job->views->link }}
    @endcomponent

    @attribute($skill.'|class:col-md-4|icon:info|label:'.__('addworking.common.skill._html.skill'))

    @component('bootstrap::attribute', ['class' => "col-md-4", 'icon' => "building"])
        @slot('label')
            {{ __('addworking.common.skill._html.enterprise') }}
        @endslot

        <a href="{{ route('enterprise.show', $skill->job->enterprise) }}">{{ $skill->job->enterprise->name }}</a>
    @endcomponent
</div>

<div class="row">
    @component('bootstrap::attribute', ['class' => "col-md-12", 'icon' => "comment-alt"])
        @slot('label')
            {{ __('addworking.common.skill._html.description') }}
        @endslot

        {{ $skill->description }}
    @endcomponent
</div>
