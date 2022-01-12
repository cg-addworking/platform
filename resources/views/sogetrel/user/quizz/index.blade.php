@extends('layouts.app')

@section('id', 'sogeterl-user-passwork-quizz-index')

@section('title')
    <div class="row">
        <div class="col-md-12">
            @component('components.panel')
                <h1 class="mb-0">{{ __('sogetrel.user.quizz.index.so_quiz') }} {{ $passwork->user->views->link }}</h1>
                <hr>
                <a href="{{ route('sogetrel.passwork.show', $passwork) }}">
                    <i class="fa fa-fw mr-2 fa-arrow-left"></i> {{ __('sogetrel.user.quizz.index.return_to_passwork') }}
                </a>
            @endcomponent
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            @component('components.panel', ['body' => false])
                @slot('table')
                    @include('sogetrel.user.quizz._table')
                @endslot
            @endcomponent

            <div class="text-center">
                {{ $quizzes->links() }}
            </div>
        </div>
        <div class="col-md-3">
            @component('components.panel')
                @slot('heading')
                    {{ __('sogetrel.user.quizz.index.actions') }}
                @endslot

                @can('create', sogetrel_passwork_quizz())
                    @component('components.action', [
                        'href'  => route('sogetrel.passwork.quizz.create', $passwork),
                        'icon'  => "plus",
                        'class' => "success",
                    ])
                        {{ __('sogetrel.user.quizz.index.add') }}
                    @endcomponent
                @endcan
            @endcomponent
        </div>
    </div>
@endsection
