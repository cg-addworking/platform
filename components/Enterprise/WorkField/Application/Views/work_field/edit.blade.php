@extends('foundation::layout.app.edit', ['action' => route('work_field.update', $work_field)])

@section('title', __('work_field::workfield.edit.title'))

@section('toolbar')
    @button(__('work_field::workfield.edit.return')."|href:#|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('work_field::work_field._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    @include('work_field::work_field._form', ['page' => 'edit'])

    @button(__('work_field::workfield.edit.edit')."|type:submit|color:success|shadow|icon:check")
@endsection
