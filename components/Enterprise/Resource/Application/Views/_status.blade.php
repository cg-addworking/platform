@switch($resource->getStatus())
    @case('active')
        <span class="badge badge-pill badge-success">{{ __('enterprise.resource.application.views._status.active') }}</span>
        @break

    @case ('inactive')
        <span class="badge badge-pill badge-warning">{{ __('enterprise.resource.application.views._status.inactive') }}</span>
        @break;

    @default
        <span>{{ $resource->getStatus() }}</span>
        @break
@endswitch
