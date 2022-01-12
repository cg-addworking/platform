@extends('layouts.app')

@section('id', 'sogeterl-user-passwork-quizz-show')

@section('title')
    <div class="row">
        <div class="col-md-12">
            @component('components.panel')
                <h1 class="mb-0">{{ __('sogetrel.user.quizz.show.so_quiz') }} {{ $passwork->user->views->link }}</h1>
                <hr>
                <a href="{{ route('sogetrel.passwork.quizz.index', $passwork) }}">
                    <i class="fa fa-fw mr-2 fa-arrow-left"></i> {{ __('sogetrel.user.quizz.show.go_back_index') }}
                </a>
            @endcomponent
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            @component('components.panel')
                {{ $quizz->views->html }}
            @endcomponent
        </div>
        <div class="col-md-3">
            @component('components.panel')
                @slot('heading')
                    {{ __('sogetrel.user.quizz.show.actions') }}
                @endslot

                @can('edit', $quizz)
                    @component('components.action', [
                        'href'  => route('sogetrel.passwork.quizz.edit', [$passwork, $quizz]),
                        'icon'  => "pencil",
                    ])
                        {{ __('sogetrel.user.quizz.show.edit') }}
                    @endcomponent
                @endcan

                <hr>

                @can('destroy', $quizz)
                    @component('components.action', [
                        'href'  => "#",
                        'icon'  => "trash",
                        'class' => "danger",
                        '_attributes' => [
                            'onclick' => "confirm('Confirmer la suppression ?') && document.forms['". ($name = uniqid('form_')) . "'].submit()",
                        ],
                    ])
                        {{ __('sogetrel.user.quizz.show.remove') }}
                    @endcomponent
                    <form name="{{ $name }}" action="{{ route('sogetrel.passwork.quizz.destroy', [$passwork, $quizz]) }}" method="POST">
                        @method('DELETE')
                        @csrf
                    </form>
                @endcan
            @endcomponent
        </div>
    </div>
@endsection
