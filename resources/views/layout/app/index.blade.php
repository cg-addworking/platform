@extends('foundation::layout.app')

@section('main')
    @include('foundation::layout.app._title')
    @include('foundation::layout.app._breadcrumb')

    @component('bootstrap::form', ['action' => $search ?? "", 'method' => "get"])
        @yield('form')

        <header class="btn-toolbar justify-content-between my-4" role="toolbar">
            <div class="btn-group" role="group" aria-label="First group">
                @if ($items instanceof \Illuminate\Contracts\Pagination\Paginator)
                    <div class="input-group mr-3">
                        <div class="input-group-append">
                            <div class="input-group-text rounded bg-light border-0"><b>{{ $items->total() }}</b>&nbsp;{{ __('layout.app.index.objects_found') }}</div>
                        </div>
                    </div>

                    <div class="input-group mr-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-light border-0">{{ __('layout.app.index.display') }}</div>
                        </div>
                        @form_control([
                            'type'        => "select",
                            'options'     => array_mirror(['25', '50', '100']),
                            'name'        => "per-page",
                            'value'       => request()->input('per-page', '25'),
                            'class'       => "form-control d-inline w-auto",
                            'required'    => true,
                        ])
                        <div class="input-group-append">
                            <div class="input-group-text bg-light border-0">{{ __('layout.app.index.elements_per_page') }}</div>
                        </div>
                    </div>
                @endif

                @if (View::hasSection('table.filter'))
                    @if (array_filter((array) request()->input('filter', [])))
                        <a href="?reset" class="btn btn-outline-danger mr-3 rounded">@icon('times') {{ __('layout.app.index.reset') }}</a>
                    @else
                        <a href="#" class="btn btn-outline-primary mr-3 rounded" data-toggle="collapse" data-target="[role=filter]" role="button" aria-expanded="true" aria-controls="filters">@icon('filter') {{ __('layout.app.index.filter') }}</a>
                    @endif
                @endif
            </div>

            <div>
                <label class="sr-only" for="search">Rechercher</label>
                <div class="input-group">
                    <input type="search" class="form-control bg-transparent" placeholder="Rechercher" name="search" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit">@icon('search')</button>
                    </div>
                </div>
            </div>
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
    @endcomponent
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
