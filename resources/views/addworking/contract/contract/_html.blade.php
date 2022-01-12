@attribute("{$contract->number}|icon:hashtag|label:".__('addworking.contract.contract._html.number'))
@attribute("{$contract->id}|icon:key|label:".__('addworking.contract.contract._html.username'))

@component('bootstrap::attribute', ['label' => __('addworking.contract.contract._html.created_at'), 'icon' => "calendar-check"])
    @date($contract->created_at)
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.contract.contract._html.owner'), 'icon' => "building"])
    {{ $contract->enterprise->views->link }}
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.contract.contract._html.model'), 'icon' => "clone"])
    {{ $contract->contractTemplate->views->link }}
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.contract.contract._html.external_identifier'), 'icon' => "hashtag"])
    @if($contract->external_identifier)
        {{ $contract->external_identifier }}
    @else
        @na
    @endif
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.contract.contract._html.effective_date'), 'icon' => "calendar-check"])
    @date($contract->valid_from)
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.contract.contract._html.term'), 'icon' => "calendar-check"])
    @date($contract->valid_until)
@endcomponent

@if (config('signinghub.enabled') && auth()->check() && $contract->file->exists)
    @component('bootstrap::attribute', ['label' => __('addworking.contract.contract._html.consult'), 'icon' => "file"])
        <a href="{{ SigningHub::getIframeSrc($contract->signinghub_package_id, auth()->user()->email) }}">{{ __('addworking.contract.contract._html.sign_in_hub') }}</a>
    @endcomponent
@endif

@component('bootstrap::attribute', ['label' => __('addworking.contract.contract._html.status'), 'icon' => "info"])
    {{ $contract->views->status }}
@endcomponent

@component('bootstrap::attribute', ['label' => __('addworking.contract.contract._html.file'), 'icon' => "file"])
    {{ $contract->file->views->link }}
@endcomponent
