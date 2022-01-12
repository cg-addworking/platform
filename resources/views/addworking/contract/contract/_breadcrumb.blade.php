@if($contract->parent->exists)
    {{ $contract->parent->views->breadcrumb(['page' => "link"]) }}

    @switch($page ?? 'index')
        @case('index')
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.addendums')."|active")
            @break
        @case('create')
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.addendums')."|href:{$contract->parent->routes->show}#nav-addendums-tab")
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.create')."|active")
            @break
        @case('show')
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.addendums')."|href:{$contract->parent->routes->show}#nav-addendums-tab")
            @breadcrumb_item("{$contract}|active")
            @break
        @case('edit')
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.addendums')."|href:{$contract->parent->routes->show}#nav-addendums-tab")
            @breadcrumb_item("{$contract}|href:{$contract->routes->show}")
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.edit')."|active")
            @break
        @case('link')
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.addendums')."|href:{$contract->parent->routes->show}#nav-addendums-tab")
            @breadcrumb_item("{$contract}|href:{$contract->routes->show}")
            @break
    @endswitch
@else
    {{ $contract->enterprise->views->breadcrumb(['page' => "link"]) }}

    @switch($page ?? 'index')
        @case('index')
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.contracts')."|active")
            @break
        @case('create')
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.contracts')."|href:{$contract->routes->index}")
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.create')."|active")
            @break
        @case('show')
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.contracts')."|href:{$contract->routes->index}")
            @breadcrumb_item("{$contract}|active")
            @break
        @case('edit')
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.contracts')."|href:{$contract->routes->index}")
            @breadcrumb_item("{$contract}|href:{$contract->routes->show}")
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.edit')."|active")
            @break
        @case('link')
            @breadcrumb_item(__('addworking.contract.contract._breadcrumb.contracts')."|href:{$contract->routes->index}")
            @breadcrumb_item("{$contract}|href:{$contract->routes->show}")
            @break
    @endswitch
@endif
