@extends('foundation::layout.app')

@section('main')
    @include('foundation::layout.app._title')
    @include('foundation::layout.app._breadcrumb')

    <form action="{{ $search ?? "" }}" method="GET">
        @yield('form')

        <header class="btn-toolbar justify-content-between my-4" role="toolbar">
            <div class="btn-group" role="group" aria-label="First group">
                @if ($items instanceof \Illuminate\Contracts\Pagination\Paginator)
                    <div class="input-group mr-3">
                        <div class="input-group-append">
                            <div class="input-group-text rounded bg-light border-0"><b>{{ $items->total() }}</b>&nbsp;{{ trans('foundation::index.objects_founded') }}</div>
                        </div>
                    </div>

                    <div class="input-group mr-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-light border-0">{{ trans('foundation::index.display') }}</div>
                        </div>
                        <select class="form-control form-control-sm d-inline w-auto" name="per-page" required>
                            <option value="25" @if(request()->input('per-page', '25') == 25) selected @endif >25</option>
                            <option value="50" @if(request()->input('per-page', '25') == 50) selected @endif >50</option>
                            <option value="100" @if(request()->input('per-page', '25') == 100) selected @endif >100</option>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text bg-light border-0">{{ trans('foundation::index.items_per_page') }}</div>
                        </div>
                    </div>
                @endif

                @if (View::hasSection('table.filter'))
                    @if (array_filter((array) request()->input('filter', [])))
                        <a href="?reset" class="btn btn-outline-danger mr-3 rounded">@icon('times') {{ trans('foundation::index.reboot') }}</a>
                    @else
                        <a href="#" class="btn btn-outline-primary mr-3 rounded" data-toggle="collapse" data-target="[role=filter]" role="button" aria-expanded="true" aria-controls="filters">@icon('filter') {{ trans('foundation::index.filter') }}</a>
                    @endif
                @endif
            </div>
            @isset($searchable_attributes)
                <div>
                    <label class="sr-only" for="search">{{ trans('foundation::index.search') }}</label>
                    <div class="input-group">

                        <select class="form-control form-control-sm mr-3" name="field" required>
                            @foreach($searchable_attributes as $key => $value)
                                <option value="{{ $key }}" @if(request()->input('field') == $key) selected @endif >{{ __($value) }}</option>
                            @endforeach
                        </select>

                        <select class="form-control form-control-sm mr-3" name="operator" required>
                            <option value="like" @if(request()->input('operator', 'like') == 'like') selected @endif >{{ __('common.infrastructure.search.views.operators.contains') }}</option>
                            <option value="equal" @if(request()->input('operator', 'like') == 'equal') selected @endif >{{ __('common.infrastructure.search.views.operators.equal') }}</option>
                        </select>

                        <input type="search" class="form-control form-control-sm bg-transparent" placeholder="{{ __('common.infrastructure.search.views.operators.search') }}" name="search" value="{{ request('search') }}">
                        <div>
                            <button class="btn btn-outline-primary btn-sm" type="submit">@icon('search')</button>
                        </div>
                    </div>
                </div>
            @endisset
        </header>

        <div class="table-responsive" style="min-height: 500px">
            @section('table')
                <table class="table table-hover">
                    <colgroup>
                        @yield('table.colgroup')
                    </colgroup>
                    <thead>
                        @yield('table.head')
                    </thead>
                    <tbody>
                        <tr role="filter" class="collapse bg-light show">
                            @yield('table.filter')
                        </tr>
                        @yield('table.body')
                    </tbody>
                    <tfoot>
                        @yield('table.foot')
                    </tfoot>
                </table>

                @yield('table.pagination')
            @show
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('[role=filter] :input').keyup(function (event) {
                if (event.key == 'Enter') {
                    $(this).parents('form').first().submit();
                }
            })

            $('[name=per-page]').change(function (event) {
                $(this).parents('form').first().submit();
            })
        })
     </script>
@endpush

@push('stylesheets')
    <style type="text/css">
        td {
            line-height: 32px;
        }
    </style>
@endpush
