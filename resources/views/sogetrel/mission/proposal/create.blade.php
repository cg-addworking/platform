@extends('layouts.app')

@section('id', 'mission-proposal-create')

@section('title')

    <div class="row">
        <div class="col-md-12">
            @component('components.panel')
                <h1 class="mb-0"> {{ __('sogetrel.mission.proposal.create.new_mission_proposal') }}</h1>
                <div class="mt-3">
                    <a href="{{ route('mission.offer.show', $offer) }}">
                        <i class="fa fa-arrow-left"></i>
                        <span>{{ __('sogetrel.mission.proposal.create.return') }}</span>
                    </a>
                </div>
            @endcomponent
        </div>
    </div>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('_form_errors')

            <form class="form" method="post" action="{{ route('sogetrel.mission.proposal.store') }}">
                @csrf

                @component('components.panel')
                    <h4>{{ __('sogetrel.mission.proposal.create.proposal_information') }}</h4>

                    @component('components.form.group', [
                         'type'     => "select",
                         'name'     => "mission_offer.id",
                         'value'    => $offer->id,
                         'values'   => [$offer->id => $offer->label],
                         'required' => true,
                         'label'    => __('sogetrel.mission.proposal.create.mission_offers'),
                     ])
                    @endcomponent

                    {{ $proposal->views->form }}
                @endcomponent


                @component('components.panel')
                    <h4>{{ __('sogetrel.mission.proposal.create.provider_selection') }}</h4>

                    @forelse($offer->sogetrelPassworks as $passwork)
                        @continue($offer->proposals->contains('vendor_passwork_id', $passwork->id))
                        <input type="hidden" name="vendor[id][]" value="{{ $passwork->id }}">
                        <p>- {{ $passwork->user->enterprise->exists ? ($passwork->user->name .' | '. $passwork->user->enterprise->name) : $passwork->user->name }}</p>
                    @empty
                        <div class="p-5">
                            <i class="fa fa-frown-o"></i> @lang('messages.empty')
                        </div>
                    @endforelse
                @endcomponent

                @component('components.panel', ['class' => 'default pull-right'])
                    <button type="submit" name="mission_proposal[status]" value="{{ mission_proposal()::STATUS_RECEIVED }}" class="btn btn-success"><i class="fa fa-check"></i> @lang('messages.save')</button>
                @endcomponent
            </form>
        </div>
    </div>
@endsection
