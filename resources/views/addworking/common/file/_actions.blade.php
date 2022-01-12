@component('foundation::layout.app._actions', ['model' => $file])
    @can('download', $file)
        @action_item(__('addworking.common.file._actions.download')."|icon:download|href:{$file->routes->download}")
    @endcan
@endcomponent
