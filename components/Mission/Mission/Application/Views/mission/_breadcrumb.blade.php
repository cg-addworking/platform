@inject('workFieldRepository', 'Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository')

@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('mission::mission._breadcrumb.dashboard')."|href:".route('dashboard'))
        @if (!is_null($workfield))
            @breadcrumb_item(__('mission::mission._breadcrumb.workfields')."|href:".route('work_field.index'))
            @breadcrumb_item($workFieldRepository->find($workfield)->getDisplayName()."|href:".route('work_field.show', $workfield))
        @endif
        @breadcrumb_item(__('mission::mission._breadcrumb.index')."|href:#")
        @breadcrumb_item(__('mission::mission._breadcrumb.create')."|active")
    @break

    @case('edit')
        @breadcrumb_item(__('mission::mission._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('mission::mission._breadcrumb.index')."|href:#")
        @breadcrumb_item($mission->getLabel()."|href:#")
        @breadcrumb_item(__('mission::mission._breadcrumb.edit')."|active")
    @break

    @case('show')
        @breadcrumb_item(__('mission::mission._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('mission::mission._breadcrumb.index')."|href:".route('mission.index'))
        @breadcrumb_item($mission->getLabel()."|active")
    @break

    @default
        @breadcrumb_item(__('mission::mission._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('mission::mission._breadcrumb.index')."|active")
@endswitch
