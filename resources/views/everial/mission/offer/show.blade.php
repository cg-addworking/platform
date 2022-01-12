@extends('addworking.mission.offer.show', [
    'profile_create' => 'everial.enterprise.offer.profile.create',
    'index'          => 'everial.mission-offer.index',
    'assign'         => 'everial.enterprise.offer.assign.index',
])

@section('mission')
    @component('bootstrap::attribute', ['class' => "col-md-12", 'icon' => "calendar-check"])
        @slot('label')
            {{ __('everial.mission.offer.show.mission') }}
        @endslot
            {{ optional($offer->everialReferentialMissions()->first())->label }}
    @endcomponent
@endsection

@section('department')
@endsection