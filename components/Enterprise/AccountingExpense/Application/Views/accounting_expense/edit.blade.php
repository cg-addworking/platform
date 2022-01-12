@extends('foundation::layout.app.edit', ['action' => route('addworking.enterprise.accounting_expense.update', [$enterprise, $accounting_expense])])

@section('title', __('accounting_expense::accounting_expense.edit.title'))

@section('toolbar')
    @button(__('accounting_expense::accounting_expense.edit.return')."|href:".route('addworking.enterprise.accounting_expense.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('accounting_expense::accounting_expense._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    @include('accounting_expense::accounting_expense._form', ['page' => 'edit'])

    @button(__('accounting_expense::accounting_expense.edit.edit')."|type:submit|color:success|shadow|icon:check")
@endsection
