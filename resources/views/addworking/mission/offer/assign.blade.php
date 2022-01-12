@extends('foundation::layout.app.index')

@section('title', __('addworking.mission.offer.assign.assign_offer_service_provider'))

@section('toolbar')
    @button(__('addworking.mission.offer.assign.return')."|href:".route($back ?? 'mission.offer.index')."|icon:arrow-left|color:secondary|outline|sm|ml:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.offer.assign.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.offer.assign.mission_offer')."|active")
@endsection

@section('table.colgroup')
    <col width="90%">
    <col width="10%">
@endsection

@section('table.head')
    @th(__('addworking.mission.offer.assign.service_provider')."|not_allowed")
    @th("Action|not_allowed|class:text-right")
@endsection

@section('table.body')
    @forelse ($offer->customer->family()->vendors() as $vendor)
        <tr>
            <td>{{ $vendor->name }}</td>
            <td class="text-right">
                <button type="button" class="btn btn-outline-success btn-sm ml-2" data-toggle="modal" data-target="#assign-modal-{{$vendor->id}}">
                    <i class="fas fa-fw fa-check"></i> {{__('addworking.mission.offer.assign.assign')}}
                </button>
                @push('modals')
                    @include('addworking.mission.offer.assign_modal')
                @endpush
            </td>
        </tr>
    @empty
        <tr>
            <td>@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
