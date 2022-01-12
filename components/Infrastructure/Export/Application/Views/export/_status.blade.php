@switch ($export->getStatus())
    @case ($export::STATUS_GENERATED)
    <span class="badge badge-pill badge-success">{{ __("common.infrastructure.export.application.views.export._status.{$export->getStatus()}") }}</span>
    @break
    @case ($export::STATUS_GENERATION_PROCESSING)
    <span class="badge badge-pill badge-primary">{{ __("common.infrastructure.export.application.views.export._status.{$export->getStatus()}") }}</span>
    @break
    @case ($export::STATUS_FAILED)
    <span class="badge badge-pill badge-danger">{{ __("common.infrastructure.export.application.views.export._status.{$export->getStatus()}") }}</span>
    @break
@endswitch
