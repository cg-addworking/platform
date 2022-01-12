@switch($proposal->status)
    @case('received')
        <span class="badge badge-pill badge-warning">@lang("mission.proposal.status.{$proposal->status}")</span>
        @break

    @case('interested')
        <span class="badge badge-pill badge-warning">@lang("mission.proposal.status.{$proposal->status}")</span>
        @break

    @case('bpu_sended')
        <span class="badge badge-pill badge-primary">@lang("mission.proposal.status.{$proposal->status}")</span>
        @break

    @case('answered')
        <span class="badge badge-pill badge-primary">@lang("mission.proposal.status.{$proposal->status}")</span>
        @break

    @case('bpu_sended')
        <span class="badge badge-pill badge-primary">@lang("mission.proposal.status.{$proposal->status}")</span>
        @break

    @case('accepted')
        <span class="badge badge-pill badge-success">@lang("mission.proposal.status.{$proposal->status}")</span>
        @break

    @case('refused')
        <span class="badge badge-pill badge-danger">@lang("mission.proposal.status.{$proposal->status}")</span>
        @break

    @case('under_negotiation')
        <span class="badge badge-pill badge-danger">@lang("mission.proposal.status.{$proposal->status}")</span>
        @break

    @case('assigned')
        <span class="badge badge-pill badge-danger">@lang("mission.proposal.status.{$proposal->status}")</span>
        @break

    @case('abandoned')
        <span class="badge badge-pill badge-danger">@lang("mission.proposal.status.{$proposal->status}")</span>
        @break

    @case('draft')
        <span class="badge badge-pill badge-danger">@lang("mission.proposal.status.{$proposal->status}")</span>
        @break
@endswitch
