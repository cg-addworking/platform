@extends('foundation::layout.app.show')

@section('title', $data['display_name'] . (isset($data['external_id']) ? ' ('.$data['external_id'].')' : ''))

@section('toolbar')
    @button(__('work_field::workfield.show.return')."|href:#|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @include('work_field::work_field._actions_show')
@endsection

@section('breadcrumb')
    @include('work_field::work_field._breadcrumb', ['page' => "show"])
@endsection

@section('content')
    @include('work_field::work_field._html')
@endsection
