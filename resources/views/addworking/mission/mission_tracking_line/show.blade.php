@inject('repo', 'App\Repositories\Addworking\Contract\ContractRepository')

@extends('foundation::layout.app.show')

@section('title', "{$mission_tracking_line}")

@section('toolbar')
    @button(__('messages.return')."|href:{$mission_tracking_line->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $mission_tracking_line->views->actions }}
@endsection

@section('breadcrumb')
    {{ $mission_tracking_line->views->breadcrumb(['page' => "show"]) }}
@endsection

@section('content')
    {{ $mission_tracking_line->views->html }}
@endsection
