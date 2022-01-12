@component('foundation::layout.app._actions', ['model' => $company])
    @can('show', $company)
        <a class="dropdown-item" href="{{ route('company.show', $company) }}">
            @icon('eye|mr:3|color:muted') {{ __('company::company._actions.show') }}
        </a>
    @endcan
@endcomponent
