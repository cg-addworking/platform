@switch($response->status)
    @case('pending')
        <span class="badge badge-pill badge-warning">@lang("mission.response.status.{$response->status}")</span>
        @break

    @case('ok_to_meet')
        <span class="badge badge-pill badge-primary">@lang("mission.response.status.{$response->status}")</span>
        @break

    @case('interview_requested')
        <span class="badge badge-pill badge-primary">@lang("mission.response.status.{$response->status}")</span>
        @break

    @case('interview_positive')
        <span class="badge badge-pill badge-primary">@lang("mission.response.status.{$response->status}")</span>
        @break

    @case('final_validation')
        <span class="badge badge-pill badge-success">@lang("mission.response.status.{$response->status}")</span>
        @break

    @case('refused')
        <span class="badge badge-pill badge-danger">@lang("mission.response.status.{$response->status}")</span>
        @break
@endswitch
