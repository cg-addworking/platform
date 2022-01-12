@component('foundation::layout.app._actions', ['model' => $csv_loader_report])
    @can('download', $csv_loader_report)
        <a class="dropdown-item" href="{{ $csv_loader_report->routes->download }}">
            @icon('download|color:muted|mr:3') {{ __('addworking.common.csv_loader_report._actions.download_csv_of_errors') }}
        </a>
    @endcan
@endcomponent
