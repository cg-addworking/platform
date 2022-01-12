{{--
    Usages:

        1. As a blade directive:
        @actions($model)

        2. As a component:
        @component('foundation::layout.app._actions', ['model' => $user])
            @action_item("Se connecter|icon:magic|href:{$user->routes->index}")
        @endcomponent

--}}
<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle object-action-button" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            data-action_path="{{$action_path ?? ''}}" data-action_objects="{{$action_objects ?? ''}}" data-action_lazy_loading_activated="0">
        {{ trans('foundation::actions.actions') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right pre-scrollable" aria-labelledby="{{ $id }}">
        @if (isset($model, $model->routes->show) && (auth()->user()->can('show', $model) || auth()->user()->can('view', $model)))
            @action_item(__('foundation::actions.show')."|href:{$model->routes->show}|icon:eye")
        @endif

        @if (isset($model, $model->routes->edit) && (auth()->user()->can('update', $model) || auth()->user()->can('edit', $model)))
            @action_item(__('foundation::actions.edit')."|href:{$model->routes->edit}|icon:edit")
        @endif

        @isset ($slot)
            {{ $slot }}
        @endisset

        @if (isset($model, $model->routes->destroy) && (auth()->user()->can('delete', $model) || auth()->user()->can('destroy', $model)))
            <div class="dropdown-divider"></div>
            @action_item(__('foundation::actions.delete')."|href:{$model->routes->destroy}|icon:trash|destroy")
        @endif
    </div>
</div>
