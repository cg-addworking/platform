@extends('sogetrel.user.passwork._search')

@section('form-action', "#")

@section('form-buttons')
    @button(__('sogetrel.mission.profile._search.reinitialize')."|icon:sync|color:secondary|outline|sm|href:".route('sogetrel.mission.offer.profile.create', $offer)."?reset")
    @button(__('sogetrel.mission.profile._search.search')."|type:submit|icon:search|color:primary|outline|sm")
@endsection

