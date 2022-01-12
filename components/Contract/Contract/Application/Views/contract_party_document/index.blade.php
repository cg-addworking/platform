@extends('foundation::layout.app.show')

@section('title',__('components.contract.contract.application.views.contract_party_document.index.title', [
        'enterprise' => $contract_party->getEnterprise()->name,
        'name' => $contract_party->contract->getName(),
]))

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract_party_document.index.return')."|href:".route('contract.show', $contract_party->getContract() )."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('contract::contract_party_document._breadcrumb', ['page' => "index"])
@endsection

@section('content')
    <table class="table table-hover">
        <colgroup>
            <col width="45%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="25%">
        </colgroup>

        <thead>
            <th>{{ __('addworking.enterprise.document.index.document_name') }}</th>
            <th>{{ __('addworking.enterprise.document.index.deposit_date') }}</th>
            <th>{{ __('addworking.enterprise.document.index.expiration_date') }}</th>
            <th>{{ __('addworking.enterprise.document.index.status') }}</th>
            <th class="text-right">Actions</th>
        </thead>

        <tbody>
            @include('contract::contract_party_document._table_row')
        </tbody>
    </table>
@endsection
