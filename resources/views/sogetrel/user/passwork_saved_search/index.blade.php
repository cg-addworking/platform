@extends('layouts.app')

@section('id', 'saved_searches-index')

@section('title')
    @component('components.panel')
        <h1 class="m-0">{{ __('sogetrel.user.passwork_saved_search.index.list_passwork_search_criteria') }}</h1>

        <div class="mt-3">
             <a href="{{ route('sogetrel.passwork.index') }}">
                <i class="fa fa-arrow-left"></i>
                <span>{{ __('sogetrel.user.passwork_saved_search.index.return') }}</span>
            </a>
        </div>
    @endcomponent
@endsection
@section('content')
    @component('components.panel', ['body' => false])
        @slot('table')
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        @if(auth()->user()->isSupport())
                            <th>{{ __('sogetrel.user.passwork_saved_search.index.uuid') }}</th>
                        @endif
                        <th>{{ __('sogetrel.user.passwork_saved_search.index.search_name') }}</th>
                        <th>{{ __('sogetrel.user.passwork_saved_search.index.search_created_at') }}</th>
                        <th class="text-right">{{ __('sogetrel.user.passwork_saved_search.index.start_research') }}</th>
                        <th class="text-right">{{ __('sogetrel.user.passwork_saved_search.index.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($passwork_saved_searches as $passwork_saved_search)
                        <tr>
                            @if(auth()->user()->isSupport())
                                <td>@component('components.id'){{ $passwork_saved_search->id }}@endcomponent</td>
                            @endif
                            <td>{{ $passwork_saved_search->name }}</td>
                            <td>@date($passwork_saved_search->created_at)</td>
                            <td class="text-right"><a href="{{ route('sogetrel.passwork.index') . "?" . $passwork_saved_search->query_string }}" class="btn btn-success pull-right"><i class="mr-2 fa fa-check"></i>{{ __('sogetrel.user.passwork_saved_search.index.apply_search') }}</a></td>
                            <td class="text-right">{{ $passwork_saved_search->views->actions }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endslot
    @endcomponent

    @if ($passwork_saved_searches->lastPage() > 1)
        @component('components.panel', ['pull' => "left"])
            {{ $passwork_saved_searches->views->link }}
        @endcomponent
    @endif
@endsection
