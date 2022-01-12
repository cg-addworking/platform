<div class="row">
    <div class="col-md-8">
        @component('bootstrap::attribute')
            @slot('label')
                {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._html.amount') }}
            @endslot
            @money($mission_tracking_line_attachment->amount)
        @endcomponent

        @component('bootstrap::attribute')
            @slot('label')
                {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._html.num_order') }}
            @endslot
            {{ $mission_tracking_line_attachment->num_order }}
        @endcomponent

        @component('bootstrap::attribute')
            @slot('label')
                {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._html.num_attachment') }}
            @endslot
            {{ $mission_tracking_line_attachment->num_attachment }}
        @endcomponent

        @component('bootstrap::attribute')
            @slot('label')
                {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._html.num_site') }}
            @endslot
            {{ $mission_tracking_line_attachment->num_site }}
        @endcomponent

        @component('bootstrap::attribute')
            @slot('label')
                {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._html.signed_at') }}
            @endslot
            @date($mission_tracking_line_attachment->signed_at)
        @endcomponent

        @component('bootstrap::attribute')
            @slot('label')
                {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._html.submitted_at') }}
            @endslot
            @date($mission_tracking_line_attachment->submitted_at)
        @endcomponent

        @component('bootstrap::attribute')
            @slot('label')
                {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._html.reverse_charges') }}
            @endslot
            @bool($mission_tracking_line_attachment->reverse_charges)
        @endcomponent

        @component('bootstrap::attribute')
            @slot('label')
                {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._html.direct_billing') }}
            @endslot
            @bool($mission_tracking_line_attachment->direct_billing)
        @endcomponent
    </div>
    <div class="col-md-4">
        @component('bootstrap::attribute', ['icon' => "id-card-alt"])
            @slot('label')
                {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._html.id') }}
            @endslot
            {{ $mission_tracking_line_attachment->id }}
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "calendar-plus"])
            @slot('label')
                {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._html.created_at') }}
            @endslot
            @date($mission_tracking_line_attachment->created_at)
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "calendar-check"])
            @slot('label')
                {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._html.updated_at') }}
            @endslot
            @date($mission_tracking_line_attachment->updated_at)
        @endcomponent
    </div>
</div>
