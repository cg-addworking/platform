@extends('layouts.app')

@section('id', 'sogetrel-approval-pending')

@section('title')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @component('components.panel')
                <h1 class="m-0">{{ __('sogetrel.user.passwork.pending.account_awaiting_validation') }}</h1>
            @endcomponent
        </div>
    </div>

@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @component('components.panel')
                <h3 class="mt-2">{{ __('sogetrel.user.passwork.pending.thank_you') }}</h3>
                <p>{{ __('sogetrel.user.passwork.pending.text_line1') }}</p>

                <a href="mailto:contact@addworking.com">{{ __('sogetrel.user.passwork.pending.contact_support') }}</a>
            @endcomponent
        </div>
    </div>

@endsection
