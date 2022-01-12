@inject('workFieldRepository', 'Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository')

@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('offer::offer._breadcrumb.dashboard')."|href:".route('dashboard'))
        @if (!is_null($workfield))
            @breadcrumb_item(__('offer::offer._breadcrumb.workfields')."|href:".route('work_field.index'))
            @breadcrumb_item($workFieldRepository->find($workfield)->getDisplayName()."|href:".route('work_field.show', $workfield))
        @endif
        @breadcrumb_item(__('offer::offer._breadcrumb.index')."|href:#")
        @breadcrumb_item(__('offer::offer._breadcrumb.create')."|active")
    @break

    @case('show')
        @breadcrumb_item(__('offer::offer._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('offer::offer._breadcrumb.index')."|href:#")
        @breadcrumb_item(__('offer::offer._breadcrumb.offer', ['label' => $offer->getLabel()])."|active")
    @break

    @case('edit')
        @breadcrumb_item(__('offer::offer._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('offer::offer._breadcrumb.index')."|href:#")
        @breadcrumb_item(__('offer::offer._breadcrumb.offer', ['label' => $offer->getLabel()])."|href:".route('sector.offer.show', $offer))
        @breadcrumb_item(__('offer::offer._breadcrumb.edit')."|active")
    @break

    @case('send_to_enterprise')
        @breadcrumb_item(__('offer::offer._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('offer::offer._breadcrumb.index')."|href:#")
        @breadcrumb_item(__('offer::offer._breadcrumb.offer', ['label' => $offer->getLabel()])."|href:".route('sector.offer.show', $offer))
        @breadcrumb_item(__('offer::offer._breadcrumb.send_to_enterprise')."|active")
    @break

    @default
        @breadcrumb_item(__('offer::offer._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('offer::offer._breadcrumb.index')."|active")
@endswitch
