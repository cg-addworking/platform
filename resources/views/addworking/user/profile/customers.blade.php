@extends('foundation::layout.app.index')

@section('title', __('addworking.user.profile.customers.my_clients'))

@section('toolbar')
    @button(__('addworking.user.profile.customers.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.user.profile.customers.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.user.profile.customers.my_clients')."|active")
@endsection

@section('table.head')
    <th>{{ __('addworking.user.profile.customers.entreprise') }}</th>
@endsection

@section('table.body')
    @foreach ($items as $enterprise)
        <tr>
            <td>{{ $enterprise->name }}</td>
        </tr>
    @endforeach
@endsection
