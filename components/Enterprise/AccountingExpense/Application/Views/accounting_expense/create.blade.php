@extends('foundation::layout.app.create', ['action' => route('addworking.enterprise.accounting_expense.store', $enterprise), 'enctype' => "multipart/form-data"])

@section('title', __('accounting_expense::accounting_expense.create.title'))

@section('toolbar')
    @button(__('accounting_expense::accounting_expense.create.return')."|href:".route('addworking.enterprise.accounting_expense.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('accounting_expense::accounting_expense._breadcrumb', ['page' => "create"])
@endsection

@section('form')
    @include('accounting_expense::accounting_expense._form', ['page' => "create"])

    @button(__('accounting_expense::accounting_expense.create.create')."|type:submit|color:success|shadow|icon:check")
@endsection
