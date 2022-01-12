@component('foundation::layout.app._actions', ['model' => $job])
    @can('index', [skill(), $job])
        @action_item(__('addworking.common.job._actions.skills')."|icon:list|href:".skill([])->routes->index(compact('job')))
    @endcan
@endcomponent
