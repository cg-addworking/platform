@extends('foundation::layout.app.create', ['action' => $resource->routes->assign_post])

@section('title', __('enterprise.resource.application.views.assign.title')." {$resource->number}")

@section('toolbar')
    @button(__('enterprise.resource.application.views.assign.return')."|href:{$resource->routes->show}|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    {{ $resource->views->breadcrumb(['page' => "assign"]) }}
@endsection

@section('form')
    <fieldset>
        @form_group([
            'text'     => __('enterprise.resource.application.views.assign.client'),
            'type'     => "select",
            'name'     => "activity_period.customer_id",
            'options'  => $resource->vendor->customers->pluck('name', 'id'),
            'required' => true,
        ])

        @form_group([
            'text'     => __('enterprise.resource.application.views.assign.start_date'),
            'type'     => "date",
            'name'     => "activity_period.starts_at",
            'required' => true,
        ])

        @form_group([
            'text'     => __('enterprise.resource.application.views.assign.end_date'),
            'type'     => "date",
            'name'     => "activity_period.ends_at"
        ])
    </fieldset>

    <div class="text-right my-5">
        @button(__('enterprise.resource.application.views.assign.assign')."|type:submit|color:success|shadow|icon:link")
    </div>
@endsection
