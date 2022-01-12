@switch ($status = $document->status ?? null)
    @case (document()::STATUS_PENDING)
        <i class="fa text-warning fa-clock-o" data-toggle="tooltip" title="@lang("status.{$status}")"></i>
        @break

    @case (document()::STATUS_VALIDATED)
        <i class="fa text-success fa-check" data-toggle="tooltip" title="@lang("status.{$status}")"></i>
        @break

    @case (document()::STATUS_REJECTED)
        <i class="fa text-danger fa-ban" data-toggle="tooltip" title="@lang("status.{$status}")"></i>
        @break

    @case (document()::STATUS_OUTDATED)
        <i class="fa text-danger fa-times-circle-o" data-toggle="tooltip" title="@lang("status.{$status}")"></i>
        @break

    @default
        <small class="fa text-muted" data-toggle="tooltip" title="@lang('messages.not_applicable')">n/a</small>
        @break
@endswitch
