@extends('foundation::layout.app.index')

@section('title', __('everial.mission.referential.index.referential_missions'))

@section('toolbar')
    @can('create', referential())
        @button(__('everial.mission.referential.index.add')."|href:".route('everial.mission.referential.create')."|icon:plus|color:outline-success|outline|sm|ml:2")
    @endcan
    @can('create', mission_offer())
        @button(__('everial.mission.referential.index.new_mission_offer')."|href:".route('everial.mission-offer.create')."|icon:plus|color:outline-warning|outline|sm|ml:2")
    @endcan
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('everial.mission.referential.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('everial.mission.referential.index.referential_missions')."|active")
@endsection

@section('table.head')
    @th(__('everial.mission.referential.index.shipping_site')."|not_allowed")
    @th(__('everial.mission.referential.index.shipping_address')."|not_allowed")
    @th(__('everial.mission.referential.index.destination_site')."|not_allowed")
    @th(__('everial.mission.referential.index.destination_address')."|not_allowed")
    @th(__('everial.mission.referential.index.pallet_number').'|not_allowed')
    @th(__('everial.mission.referential.index.actions').'|not_allowed|class:text-right')
@endsection

@section('table.filter')
    <td>
        @component('bootstrap::form.control', [
            'type'  => "text",
            'name'  => "filter.shipping_site",
            'class' => "form-control-sm",
            'value' => request()->input('filter.shipping_site'),
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
            'type'  => "text",
            'name'  => "filter.shipping_address",
            'class' => "form-control-sm",
            'value' => request()->input('filter.shipping_address'),
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
            'type'  => "text",
            'name'  => "filter.destination_site",
            'class' => "form-control-sm",
            'value' => request()->input('filter.destination_site'),
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
            'type'  => "text",
            'name'  => "filter.destination_address",
            'class' => "form-control-sm",
            'value' => request()->input('filter.destination_address'),
        ])
        @endcomponent
    </td>
    <td>
        @component('bootstrap::form.control', [
            'type'  => "number",
            'min'   => 1,
            'max'   => 12,
            'name'  => "filter.pallet_number",
            'class' => "form-control-sm",
            'value' => request()->input('filter.pallet_number'),
        ])
        @endcomponent
    </td>
    <td><button class="btn btn-sm btn-primary btn-block" type="submit">@icon('check')</button></td>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $referential)
        <tr>
            <td>{{ $referential->shipping_site }}</td>
            <td>{{ $referential->shipping_address }}</td>
            <td>{{ $referential->destination_site }}</td>
            <td>{{ $referential->destination_address }}</td>
            <td>{{ $referential->pallet_number }} (type {{ $referential->pallet_type }})</td>
            <td class="text-right">{{ $referential->views->actions }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">
                <div class="p-5">
                    <i class="fa fa-frown-o"></i> @lang('messages.empty')
                </div>
            </td>
        </tr>
    @endforelse
@endsection
