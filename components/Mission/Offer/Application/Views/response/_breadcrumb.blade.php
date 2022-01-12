@switch($page ?? 'index')
    @case('create')
        @breadcrumb_item(__('offer::response._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('offer::response._breadcrumb.index_offer')."|href:#")
        @breadcrumb_item(__('offer::response._breadcrumb.offer', ['label' => $offer->getLabel()])."|href:".route('sector.offer.show', $offer))
        @breadcrumb_item(__('offer::response._breadcrumb.index')."|active")
        @breadcrumb_item(__('offer::response._breadcrumb.create')."|active")
    @break

    @case('show')
        @breadcrumb_item(__('offer::response._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('offer::response._breadcrumb.index_offer')."|href:#")
        @breadcrumb_item(__('offer::response._breadcrumb.offer', ['label' => $response->getOffer()->getLabel()])."|href:".route('sector.offer.show', $response->getOffer()))
        @breadcrumb_item(__('offer::response._breadcrumb.index')."|href:".route('sector.response.index', $response->getOffer()))
        @breadcrumb_item(__('offer::response._breadcrumb.show')."|active")
    @break

    @case('index')
        @breadcrumb_item(__('offer::response._breadcrumb.dashboard')."|href:".route('dashboard'))
        @breadcrumb_item(__('offer::response._breadcrumb.index_offer')."|href:#")
        @breadcrumb_item(__('offer::response._breadcrumb.offer', ['label' => $offer->getLabel()])."|href:".route('sector.offer.show', $offer))
        @breadcrumb_item(__('offer::response._breadcrumb.index')."|active")
    @break
@endswitch