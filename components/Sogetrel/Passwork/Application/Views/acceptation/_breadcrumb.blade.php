@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('sogetrel_passwork::acceptation._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('sogetrel_passwork::acceptation._breadcrumb.passwork', ['user_name' => $passwork->user->name])."|href:".route('sogetrel.passwork.show', $passwork))
        @breadcrumb_item(__('sogetrel_passwork::acceptation._breadcrumb.create')."|active")
    @break

    @case('index')
    @breadcrumb_item(__('sogetrel_passwork::acceptation._breadcrumb.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('sogetrel_passwork::acceptation._breadcrumb.index')."|active")
    @break

    @default
        @breadcrumb_item(__('sogetrel_passwork::acceptation._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('sogetrel_passwork::acceptation._breadcrumb.create')."|active")
@endswitch
