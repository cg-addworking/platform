@extends('layouts.app')

@section('id', 'sogetrel-user-passwork-edit')

@section('title')

    <div class="row">
        <div class="col-md-12">
            @component('components.panel')
                <h1 class="m-0">
                    <span>{{ __('sogetrel.user.passwork.edit.passwork') }}</span>
                </h1>
                <div class="mt-3">
                    @if(!auth()->user()->enterprise->is_vendor)
                        <a href="{{ route('sogetrel.passwork.index') }}">
                            <i class="fa fa-arrow-left"></i>
                            <span>{{ __('sogetrel.user.passwork.edit.return') }}</span>
                        </a> |
                    @endif
                    <b>Statut: </b>
                    @switch ($passwork->status)
                        @case (sogetrel_passwork()::STATUS_ACCEPTED)
                            <span class="text-success">
                                <i class="fa fa-check"></i>
                                <span>{{ __('sogetrel.user.passwork.edit.accept') }}</span>
                            </span>
                            @break
                        @case (sogetrel_passwork()::STATUS_REFUSED)
                            <span class="text-danger">
                                <i class="fa fa-times"></i>
                                <span>{{ __('sogetrel.user.passwork.edit.reject') }}</span>
                            </span>
                            @break
                        @case (sogetrel_passwork()::STATUS_PENDING)
                        @default
                            <span class="text-warning">
                                <i class="fa fa-clock-o"></i>
                                <span>{{ __('sogetrel.user.passwork.edit.waiting') }}</span>
                            </span>
                    @endswitch |
                    <b>{{ __('sogetrel.user.passwork.edit.created_at') }}: </b> @date($passwork->created_at)
                </div>
            @endcomponent
        </div>
    </div>

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            @component('components.panel')
                @include('_form_errors')

                <form class="form" method="post" action="{{ route('sogetrel.passwork.update', $passwork) }}" novalidate>
                    @method('PUT')
                    @csrf

                    {{ $passwork->views->form }}
                </form>
            @endcomponent
        </div>
    </div>

@endsection
