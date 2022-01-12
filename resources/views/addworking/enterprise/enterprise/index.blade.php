@extends('foundation::layout.app.index')

@section('title', __('addworking.enterprise.enterprise.index.company'))

@section('toolbar')
    @button(__('addworking.enterprise.enterprise.index.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")    
    @button(__('addworking.enterprise.enterprise.index.add')."|href:".route('enterprise.add')."|icon:plus|color:outline-success|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.enterprise.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.enterprise.index.company')."|active")
@endsection

@section('form')
    @can('seeGroups', [App\Models\Addworking\Enterprise\Enterprise::class])
        @include('addworking.enterprise.enterprise._index_form')
    @endcan
@endsection

@section('table.head')
    @th(__('addworking.enterprise.enterprise.index.society')."|column:name")
    @th(__('addworking.enterprise.enterprise.index.type')."|not_allowed")
    @th(__('addworking.enterprise.enterprise.index.leader')."|not_allowed")
    @th(__('addworking.enterprise.enterprise.index.phone')."|not_allowed")
    @th(__('addworking.enterprise.enterprise.index.created')."|column:created_at")
    @th(__('addworking.enterprise.enterprise.index.update')."|column:updated_at")
    @th(__('addworking.enterprise.enterprise.index.actions')."|not_allowed|class:text-right")
@endsection

@section('table.filter')
    <td><input class="form-control form-control-sm" type="text" name="filter[name]" value="{{ request()->input('filter.name') }}"></td>
    <td>
        <select class="form-control form-control-sm" name="filter[type]">
            <option></option>
            <option value="vendor" @if(request()->input('filter.type') == 'vendor') selected @endif>{{ __('addworking.enterprise.enterprise.index.service_provider') }}</option>
            <option value="customer" @if(request()->input('filter.type') == 'customer') selected @endif>Client</option>
            <option value="customer+vendor" @if(request()->input('filter.type') == 'customer+vendor') selected @endif>Hybride</option>
        </select>
    </td>
    <td><input class="form-control form-control-sm" type="text" name="filter[legal_representative]" value="{{ request()->input('filter.legal_representative') }}"></td>
    <td><input class="form-control form-control-sm" type="text" name="filter[phone]" value="{{ request()->input('filter.phone') }}"></td>
    <td><input class="form-control form-control-sm" type="date" name="filter[created_at]" value="{{ request()->input('filter.created_at') }}"></td>
    <td><input class="form-control form-control-sm" type="date" name="filter[updated_at]" value="{{ request()->input('filter.updated_at') }}"></td>
    <td><button class="btn btn-sm btn-primary btn-block" type="submit">@icon('check')</button></td>
@endsection

@section('table.pagination')
    {{ $items->appends(request()->except('page'))->links() }}
@endsection

@section('table.body')
    @foreach ($items as $enterprise)
        <tr>
            <td>{{ $enterprise->views->link }}</td>
            <td>@include('addworking.enterprise.enterprise._badges')</td>
            <td>{{ optional(optional($enterprise->legalRepresentatives->first())->views)->link }}</td>
            <td>{{ $enterprise->primary_phone_number }}</td>
            <td>@date($enterprise->created_at)</td>
            <td>@date($enterprise->updated_at)</td>
            <td class="text-right">{{ $enterprise->views->actions }}</td>
        </tr>
    @endforeach
@endsection
