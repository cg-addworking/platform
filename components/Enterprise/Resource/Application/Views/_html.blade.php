<div class="card shadow">
    <div class="card-body">
        @attribute("{$resource->getVendor()->name}|icon:user|label:".__('enterprise.resource.application.views._html.enterprise'))
        @component('bootstrap::attribute', ['label' => __('enterprise.resource.application.views._html.status'), 'icon' => "info"])
            @include('resource::_status')
        @endcomponent
        @attribute("{$resource->getLastName()}|label:".__('enterprise.resource.application.views._html.last_name')."|icon:user")
        @attribute("{$resource->getFirstName()}|label:".__('enterprise.resource.application.views._html.first_name')."|icon:user")
        @attribute("{$resource->getEmail()}|label:".__('enterprise.resource.application.views._html.email')."|icon:envelope")
        @attribute($resource->getRegistrationNumber() ?? "n/a"."|label:".__('enterprise.resource.application.views._html.registration_nuber')."|icon:hashtag")
        @attribute($resource->getNote() ?? "n/a"."|label:".__('enterprise.resource.application.views._html.note')."|icon:sticky-note")
    </div>
</div>
<div class="card shadow mt-2">
    <button class="btn btn-outline mt-3" type="button" data-toggle="collapse" data-target="#collapseMoreInfo" aria-expanded="false" aria-controls="collapseMoreInfo">
        <h5 class="card-title">@icon('caret-down') {{ __('enterprise.resource.application.views._html.complementary_information') }}</h5>
    </button>
    <div class="collapse" id="collapseMoreInfo">
        <div class="card-body">
            @component('bootstrap::attribute', ['label' => __('enterprise.resource.application.views._html.uuid'), 'icon' => "hashtag"])
                <span class="clipboard" style="font-family: monospace" data-clipboard-text="{{ $resource->getId() }}" title="{{ __('enterprise.resource.application.views._html.copy_to_clipboard') }}" data-toggle="tooltip">{{ $resource->getId() }}</span>
            @endcomponent
            @attribute("{$resource->getNumber()}|label:".__('enterprise.resource.application.views._html.number')."|icon:hashtag")
            @attribute("{$resource->created_at}|icon:calendar-plus|label:".__('enterprise.resource.application.views._html.created_at'))
            @attribute("{$resource->updated_at}|icon:calendar-check|label:".__('enterprise.resource.application.views._html.updated_at'))
            @component('bootstrap::attribute', ['label' => __('enterprise.resource.application.views._html.deleted_at'), 'icon' => "calendar-times"])
                {{ $resource->deleted_at ?? "n/a" }}
            @endcomponent
        </div>
    </div>
</div>
