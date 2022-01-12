@extends('layouts.app')

@section('id', 'sogeterl-user-passwork-quizz-edit')

@section('title')
    <div class="row">
        <div class="col-md-12">
            @component('components.panel')
                <h1 class="mb-0">{{ __('sogetrel.user.quizz.edit.so_quiz') }} {{ $passwork->user->views->link }}</h1>
                <hr>
                <a href="{{ route('sogetrel.passwork.quizz.show', [$passwork, $quizz]) }}">
                    <i class="fa fa-fw mr-2 fa-arrow-left"></i> {{ __('sogetrel.user.quizz.edit.return_to_quiz') }}
                </a>
            @endcomponent
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('sogetrel.passwork.quizz.update', [$passwork, $quizz]) }}" method="POST" class="form form-horizontal">
                @csrf
                @method('put')
                @include('_form_errors')
                @component('components.panel')
                    {{ $quizz->views->form }}

                    @slot('footer')
                        <div class="text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-fw mr-2 fa-save"></i> {{ __('sogetrel.user.quizz.edit.save') }}
                            </button>
                        </div>
                    @endslot
                @endcomponent
            </form>
        </div>
    </div>
@endsection
