@component('components.form.modal', [
    'id'     => sprintf("reject-line-%s-%s", $is_vendor ? "vendor" : "customer", $mission_tracking_line->id),
    'action' => "{$mission_tracking_line->routes->validation}?back"
])
    @slot('title')
        {{ __('addworking.mission.mission_tracking_line._reject.decline_tracking') }}
        @if ($is_vendor)
            ({{ __('addworking.mission.mission_tracking_line._reject.service_provider') }})
        @else
            ({{ __('addworking.mission.mission_tracking_line._reject.client') }})
        @endif
    @endslot

    @if ($is_vendor)
        <input type="hidden" name="line[validation_vendor]" value="{{ $mission_tracking_line::STATUS_REJECTED }}">
    @else
        <input type="hidden" name="line[validation_customer]" value="{{ $mission_tracking_line::STATUS_REJECTED }}">
    @endif
+
    @form_group([
        'type'     => 'select',
        'name'     => "line.reason_for_rejection",
        'required' => true,
        'options'  => $mission_tracking_line->getAvailableReasonForRejection(true),
        'text'     => __('addworking.mission.mission_tracking_line._reject.refusal_reason'),
    ])
@endcomponent
