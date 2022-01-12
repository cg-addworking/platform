@component('components.modal', ['id' => "add-proposal-{$offer->id}"])
    @slot('title')
        {{ __('addworking.mission.proposal.create.broadcast') }}: {{ $offer->label }}
    @endslot

    <div class="row">
        @form_group([
            'class' => 'col-md-12',
            'type'  => 'switch',
            'name'  => 'mission_proposal.send_invitation',
            'text'  => __('mission.proposal.send_invitation'),
        ])

        @form_group([
            'class'       => 'col-md-12',
            'type'        => "date",
            'name'        => "mission_proposal.valid_from",
            'required'    => true,
            'text'        => __('mission.proposal.valid_from'),
        ])

        @form_group([
            'class'       => 'col-md-12',
            'type'        => "date",
            'name'        => "mission_proposal.valid_until",
            'required'    => false,
            'text'        => __('mission.proposal.valid_until'),
        ])

        @form_group([
            'class'       => 'col-md-12',
            'type'        => "textarea",
            'name'        => "mission_proposal.details",
            'required'    => false,
            'text'        => __('mission.proposal.details'),
            'rows'        => 6
        ])
    </div>

    @slot('footer')
        <a class="btn btn-default" data-dismiss="modal">{{ __('addworking.mission.proposal.create.close') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('addworking.mission.proposal.create.broadcast') }}</button>
    @endslot
@endcomponent