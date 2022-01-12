@extends('foundation::layout.app.index')

@section('title', __('company::company.index.enterprise'))

@section('toolbar')
    @button(__('company::company.index.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('company::company.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('company::company.index.enterprise')."|active")
@endsection

@section('table.head')
    @th(__('company::company.index.name')."|column:name")
    @th(__('company::company.index.identification_number')."|not_allowed")
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $company)
        <tr>
            <td><a href="{{route('company.show', $company)}}">{{ $company->getLegalForm()->getDisplayName() }} - {{ $company->getName() }}</a></td>
            <td>{{ $company->getIdentificationNumber() }}</td>
        </tr>
    @endforeach
@endsection