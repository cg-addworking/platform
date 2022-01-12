@inject('accountingExpenseRepository', 'Components\Enterprise\AccountingExpense\Application\Repositories\AccountingExpenseRepository')

@extends('foundation::layout.app.index')

@section('title', __('accounting_expense::accounting_expense.index.title'))

@section('toolbar')
    @can('create', [accounting_expense(), $enterprise])
        @button(__('accounting_expense::accounting_expense.index.create')."|href:".route('addworking.enterprise.accounting_expense.create', $enterprise)."|icon:list-alt|color:success|outline|sm|mr:2")
    @endcan
    @button(__('accounting_expense::accounting_expense.index.return')."|href:".route('addworking.enterprise.accounting_expense.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
     @include('accounting_expense::accounting_expense._breadcrumb')
@endsection

@section('table.head')
    @include('accounting_expense::accounting_expense._table_head')
@endsection

@section('table.pagination')
    {{ $items->withQueryString()->links() }}
@endsection

@section('table.body')
    @foreach ($items as $accounting_expense)
        @include('accounting_expense::accounting_expense._table_row')
    @endforeach
@endsection
