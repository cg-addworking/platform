<div class="row">
    <div class="col-md-9">
        <div class="card shadow">
            <div class="card-body">
                @if (! is_null($annex->getFile()))
                    {{ $annex->getFile()->views->iframe(['ratio' => "4by3"]) }}
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="row">
            <div class="card shadow mt-2" style="width: 100%">
                <h6 class="card-title mt-3 ml-3">{{ __('components.contract.contract.application.views.annex._html.informations') }}</h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.annex._html.display_name'), 'icon' => "tag"])
                                <div class="ml-3">{{ $annex->getDisplayName()}}</div>
                            @endcomponent
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.annex._html.description'), 'icon' => "tag"])
                                <div class="ml-3">
                                    @if(strlen($annex->getDescription()) > 50)
                                        {{ substr($annex->getDescription(), 0, 50) }} ...
                                        <a href="#" tabindex="0" data-container="body" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="{{ $annex->getDescription() }}">Voir plus</a>
                                    @else
                                        {{ $annex->getDescription() }}
                                    @endif
                                </div>
                            @endcomponent
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            @component('bootstrap::attribute', ['label' => __('components.contract.contract.application.views.annex._html.owner')])
                                <div class="ml-3">{{ $annex->getEnterprise()->views->link }}</div>
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card shadow mt-2" style="width: 100%">
                <h6 class="card-title mt-3 ml-3">{{ __('components.contract.contract.application.views.annex._html.more_informations') }}</h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @attribute("{$annex->getCreatedAt()}|icon:calendar-plus|label:".__('components.contract.contract.application.views.annex._html.created_date'))
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @attribute("{$annex->getUpdatedAt()}|icon:calendar-check|label:".__('components.contract.contract.application.views.annex._html.last_modified_date'))
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

