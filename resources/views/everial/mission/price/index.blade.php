@extends('foundation::layout.app.index')

@section('title', __('everial.mission.price.index.price_list'))

@section('toolbar')
    @button(__('everial.mission.price.index.return')."|href:{$referential->routes->index}|icon:arrow-left|color:secondary|outline|sm|ml:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('everial.mission.price.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('everial.mission.price.index.mission_repo').'|href:'.$referential->routes->index )
    @breadcrumb_item($referential->label .'|href:'.$referential->routes->show )
    @breadcrumb_item(__('everial.mission.price.index.price_list')."|active")
@endsection

@section('table.head')
    @th(__('everial.mission.price.index.service_provider')."|not_allowed")
    @th(__('everial.mission.price.index.rate').'|not_allowed')
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $price)
        <tr>
            <td>{{ $price->vendor->views->link }}</td>
            <td>@money($price->amount)</td>
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
