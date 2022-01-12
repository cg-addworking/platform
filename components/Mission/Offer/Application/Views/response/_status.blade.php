@switch($response->getStatus())
    @case('pending')
        <span class="badge badge-pill badge-primary">{{ __('offer::response._status.pending') }}</span>
        @break

    @case ('accepted')
        <span class="badge badge-pill badge-success">{{ __('offer::response._status.accepted') }}</span>
        @break;

    @case ('refused')
        <span class="badge badge-pill badge-danger">{{ __('offer::response._status.refused') }}</span>
        @break;

    @case ('not_selected')
        <span class="badge badge-pill badge-secondary">{{ __('offer::response._status.not_selected') }}</span>
    @break;

    @default
        <span class="badge badge-pill badge-secondary">{{ $response->getStatus() }}</span>
        @break
@endswitch
