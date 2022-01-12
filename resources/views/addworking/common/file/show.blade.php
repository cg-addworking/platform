@extends('foundation::layout.app.show')

@section('title', $file->basename)

@section('toolbar')
    {{ $file->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.common.file.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.common.file.show.files')."|href:".route('file.index'))
    @breadcrumb_item($file->basename ."|active")
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    @if($file->common_url)
                        {{ $file->views->iframe(['ratio' => "4by3"]) }}
                    @else
                        {{__('addworking.common.file.show.error')}}
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            {{ $file->views->html }}
        </div>
    </div>
@endsection
