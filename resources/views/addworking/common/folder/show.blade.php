@extends('foundation::layout.app.show')

@section('title', $folder->display_name)

@section('toolbar')
    @button(__('addworking.common.folder.show.return')."|href:{$folder->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ $folder->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.folder.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.folder.show.enterprises')."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.common.folder.show.files')."|href:{$folder->routes->index}")
    @breadcrumb_item("{$folder}|active")
@endsection

@section('tabs')
    <a class="nav-item nav-link" id="nav-content-tab" data-toggle="tab" href="#nav-content" role="tab" aria-controls="nav-content" aria-selected="false">{{ __('addworking.common.folder.show.content') }}</a>

    @if(auth()->user()->enterprise->id == $folder->enterprise->id)
        <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{ __('addworking.common.folder.show.general_information') }}</a>
    @endif
@endsection

@section('content')
    <div class="tab-pane fade" id="nav-content" role="tabpanel" aria-labelledby="nav-content-tab">
        {{ $folder->views->items }}
    </div>
    @if (auth()->user()->enterprise->id == $folder->enterprise->id)
        <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
            {{ $folder->views->html }}
        </div>
    @endif
@endsection
