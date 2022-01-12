@extends('foundation::layout.app.index')

@section('title', __('addworking.enterprise.site.index.company_sites')." ".$enterprise->name)

@section('toolbar')
    @button(__('addworking.enterprise.site.index.return')."|href:".$enterprise->routes->show."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @button(__('addworking.enterprise.site.index.add')."|href:".$site->routes->create."|icon:plus|color:outline-success|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.site.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item('Entreprises|href:'.$enterprise->routes->index )
    @breadcrumb_item($enterprise->name .'|href:'.$enterprise->routes->show )
    @breadcrumb_item("Sites|active")
@endsection

@section('table.head')
    @th(__('addworking.enterprise.site.index.last_name')."|column:name")
    @th("Code|column:analytic_code")
    @th(__('addworking.enterprise.site.index.phone')."|not_allowed")
    @th(__('addworking.enterprise.site.index.address')."|not_allowed")
    @th(__('addworking.enterprise.site.index.created_the')."|column:created_at")
    @th("Action|not_allowed|class:text-right")
@endsection

@section('table.filter')
    <td><input class="form-control form-control-sm" type="text" name="filter[name]" value="{{ request()->input('filter.name') }}"></td>
    <td><input class="form-control form-control-sm" type="text" name="filter[code]" value="{{ request()->input('filter.code') }}"></td>
    <td><input class="form-control form-control-sm" type="text" name="filter[phone]" value="{{ request()->input('filter.phone') }}"></td>
    <td><input class="form-control form-control-sm" type="text" name="filter[address]" value="{{ request()->input('filter.address') }}"></td>
    <td><input class="form-control form-control-sm" type="date" name="filter[created_at]" value="{{ request()->input('filter.created_at') }}"></td>
    <td><button class="btn btn-sm btn-primary btn-block" type="submit">@icon('check')</button></td>
@endsection

@section('table.pagination')
    {{ $items->appends(request()->except('page'))->links() }}
@endsection

@section('table.body')
    @foreach ($items as $site)
        <tr>
            <td>{{ $site->display_name }}</td>
            <td>{{ $site->analytic_code }}</td>
            <td>{{ optional($site->phoneNumbers->first())->number }}</td>
            <td>{{ optional($site->addresses->first())->one_line }}</td>
            <td>@date($site->created_at)</td>
            <td class="text-right">{{ $site->views->actions }}</td>
        </tr>
    @endforeach
@endsection
