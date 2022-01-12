@extends('foundation::layout.app.index')

@section('title', __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.title'))

@section('toolbar')
    @can('create', get_class($mission_tracking_line_attachment))
        @button(
            __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.add').
            "|href:{$mission_tracking_line_attachment->routes->create}|icon:plus|color:outline-success|outline|sm"
        )
    @endcan
@endsection

@section('breadcrumb')
    {{ $mission_tracking_line_attachment->views->breadcrumb(['page' => "index"]) }}
@endsection

@section('form')
    <div class="row">
        <div class="col-md-3">
            @form_group([
                'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.filter_inbound_invoice'),
                'type' => "select",
                'name' => "has_inbound_invoice",
                'options' => [
                    "no" => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.doesnt_have_inbound_invoice'),
                    "yes" => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.has_inbound_invoice'),
                ],
                'value' => request('has_inbound_invoice'),
            ])
        </div>
        <div class="col-md-3">
            @form_group([
                'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.filter_outbound_invoice'),
                'type' => "select",
                'name' => "has_outbound_invoice",
                'options' => [
                    "no" => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.doesnt_have_outbound_invoice'),
                    "yes" => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.has_outbound_invoice'),
                ],
                'value' => request('has_outbound_invoice'),
            ])
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
    </div>
@endsection

@section('table.head')
    <th>{{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.customer') }}</th>
    <th>{{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.vendor') }}</th>
    <th>{{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.mission') }}</th>
    <th>{{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.milestone') }}</th>
    <th class="text-right">{{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.amount') }}</th>
    <th>{{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.num_attachment') }}</th>
    <th>{{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.num_order') }}</th>
    <th>{{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.signed_at') }}</th>
    <th>{{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.inbound_invoice') }}</th>
    <th>{{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.outbound_invoice') }}</th>
    <th class="text-center">{{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.direct_billing') }}</th>
    <th class="text-center">{{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.index.created_from_airtable') }}</th>
    <th>{{ __('messages.actions') }}</th>
@endsection

@section('table.colgroup')
    <col>
    <col>
    <col>
    <col>
    <col width="125px">
    <col>
    <col>
    <col>
    <col>
    <col>
    <col>
    <col>
    <col>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $mission_tracking_line_attachment)
        <tr>
            <td>{{ $mission_tracking_line_attachment->missionTrackingLine->missionTracking->mission->customer->views->link }}</td>
            <td>{{ $mission_tracking_line_attachment->missionTrackingLine->missionTracking->mission->vendor->views->link }}</td>
            <td>{{ $mission_tracking_line_attachment->missionTrackingLine->missionTracking->mission->views->link }}</td>
            <td>{{ $mission_tracking_line_attachment->missionTrackingLine->missionTracking->milestone->views->link }}</td>
            <td class="text-right">@money($mission_tracking_line_attachment->amount)</td>
            <td>@valorna($mission_tracking_line_attachment->num_attachment)</td>
            <td>@valorna($mission_tracking_line_attachment->num_order)</td>
            <td>@date($mission_tracking_line_attachment->signed_at)</td>
            <td>{{ $mission_tracking_line_attachment->views->inbound_invoices }}</td>
            <td>{{ $mission_tracking_line_attachment->views->outbound_invoices }}</td>
            <td class="text-center">@bool($mission_tracking_line_attachment->direct_billing)</td>
            <td class="text-center">@bool($mission_tracking_line_attachment->created_from_airtable)</td>
            <td>{{ $mission_tracking_line_attachment->views->actions }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="999">{{ __('messages.empty') }}</td>
        </tr>
    @endforelse
@endsection
