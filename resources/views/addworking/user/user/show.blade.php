@extends('foundation::layout.app.show')

@section('title', $user->name)

@section('toolbar')
    @if(auth()->user()->isSupport())
        @button(__('addworking.user.user.show.connect')."|href:".route('impersonate', $user)."|icon:magic|color:outline-success|outline|sm|mr:2")
    @endif
    {{ $user->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.user.user.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.user.user.show.users').'|href:'.route('user.index') )
    @breadcrumb_item($user->name ."|active")
@endsection

@section('tabs')
    <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{ __('addworking.user.user.show.general_information') }}</a>
    @support
        <a class="nav-item nav-link" id="nav-comments-tab" data-toggle="tab" href="#nav-comments" role="tab" aria-controls="nav-comments" aria-selected="false">{{ __('addworking.user.user.show.comments') }}</a>
    @endsupport
@endsection

@section('content')
    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
        <div class="row">
            {{ $user->views->html }}
        </div>
    </div>

    @support
        <div class="tab-pane fade" id="nav-comments" role="tabpanel" aria-labelledby="nav-comments-tab">
            <div class="row">
                @include('addworking.common.comment._create', ['item' => $user])

                {{ $user->comments }}
            </div>
        </div>
    @endsupport
@endsection
