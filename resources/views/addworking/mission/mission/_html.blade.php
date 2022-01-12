<h3 id="{{ $mission->id }}">
    {{ $mission->label }}
    <a href="{{ route('mission.show', $mission) }}" @tooltip(__('addworking.mission.mission._html.permalink'))>
        <i class="fa fa-link"></i>
    </a>
</h3>

@if(auth()->check() && auth()->user()->isSupport())
    <p>
        <small class="text-muted mr-3" @tooltip(__('addworking.mission.mission._html.number'))>
            <i class="fa fa-hashtag"></i> <b>{{ $mission->number }}</b>
        </small>
        <small class="text-muted" @tooltip(__('addworking.mission.mission._html.user_id'))>
            <i class="fa fa-key"></i> {{ $mission->id }}
        </small>
    </p>
@endif

<hr>

<h5>Description:</h5>
<p>{{ $mission->description ?: 'n/a' }}</p>

<hr>

<div class="row">
    <div class="col-md-4">
        @component('components.attribute', ['icon' => "user-circle-o", 'name' => __('addworking.mission.mission._html.service_provider')])
            {{ $mission->vendor->views->link }}
        @endcomponent

        @component('components.attribute', ['icon' => "user-circle", 'name' => "Client"])
            {{ $mission->customer->views->link }}
        @endcomponent

        @component('components.attribute', ['icon' => "calendar-check-o", 'name' => __('addworking.mission.mission._html.start')])
            @date($mission->starts_at)
        @endcomponent

        @component('components.attribute', ['icon' => "calendar-times-o", 'name' => __('addworking.mission.mission._html.end')])
            @date($mission->ends_at)
        @endcomponent
    </div>

    <div class="col-md-4">
        @component('components.attribute', ['icon' => "check", 'name' => __('addworking.mission.mission._html.status')])
            @include('addworking.mission.mission._status')
        @endcomponent

        @component('components.attribute', ['icon' => "credit-card", 'name' => __('addworking.mission.mission._html.amount')])
            @money($mission->amount)
        @endcomponent

        @component('components.attribute', ['icon' => "line-chart", 'name' => __('addworking.mission.mission._html.unit')])
            {{ $mission->quantity}}x @lang("mission.mission.unit_{$mission->unit}")
        @endcomponent

        @component('components.attribute', ['icon' => "map-marker", 'name' => __('addworking.mission.mission._html.location')])
            {{ $mission->location }}
        @endcomponent
    </div>

    <div class="col-md-4">
        @component('components.attribute', ['icon' => "star", 'name' => "Note"])
            @for($i = 1; $i <= $mission->note; $i++)
                <i class="fa fa-star"></i>
            @endfor
            @for($i = 5; $i > $mission->note; $i--)
                <i class="fa fa-star-o"></i>
            @endfor
        @endcomponent
    </div>
</div>

@if(auth()->check() && !auth()->user()->enterprise->is_vendor)
    @if(in_array($mission->status, [mission()::STATUS_DONE, mission()::STATUS_CLOSED]))
        <a class="btn btn-primary" title="Noter" data-toggle="modal" data-target="#add-note">
            <i class="fa fa-star"></i>
            {{ __('addworking.mission.mission._html.rate_mission') }}
        </a>

        @component('components.form.modal', ['id' => 'add-note', 'action' => route('mission.note', $mission)])
            @slot('title')
                {{ __('addworking.mission.mission._html.add_note') }}
            @endslot

            @component('components.form.group', ['type' => 'number', 'name' => "mission.note", 'required' => true])
                @slot('label')
                    <i class="fa fa-star"></i> Note
                @endslot

                @slot('placeholder')
                    1 - 5
                @endslot
            @endcomponent
        @endcomponent
    @endif
@endif
