@extends('layouts.app')

@section('id', 'sogeterl-user-passwork-quizz-create')

@section('title')
    <div class="row">
        <div class="col-md-12">
            @component('components.panel')
                <h1 class="mb-0">{{ __('sogetrel.user.quizz.create.new_so_quiz') }} {{ $passwork->user->views->link }}</h1>
                <hr>
                <a href="{{ route('sogetrel.passwork.quizz.index', $passwork) }}">
                    <i class="fa fa-fw mr-2 fa-arrow-left"></i> {{ __('sogetrel.user.quizz.create.go_back_index') }}
                </a>
            @endcomponent
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('sogetrel.passwork.quizz.store', $passwork) }}" method="POST" class="form form-horizontal">
                @csrf
                @include('_form_errors')
                @component('components.panel')
                    {{ $quizz->views->form }}

                    @slot('footer')
                        <div class="text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-fw mr-2 fa-save"></i> {{ __('sogetrel.user.quizz.create.save') }}
                            </button>
                        </div>
                    @endslot
                @endcomponent
            </form>
        </div>
    </div>
@endsection
