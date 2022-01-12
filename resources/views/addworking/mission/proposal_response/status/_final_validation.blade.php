@component('components.form.modal', [
    'id' => "final-validation-proposal-response-{$response->id}",
    'action' => route('enterprise.offer.proposal.response.status', [$response->proposal->offer->customer, $response->proposal->offer, $response->proposal, $response])]
    )
    @slot('title')
        {{ __('addworking.mission.proposal_response.status._final_validation.change_resp_status') }}: @lang("mission.response.status.final_validation")
    @endslot

    <input type="hidden" name="response[status]" value="{{ proposal_response()::STATUS_FINAL_VALIDATION }}">
    <input type="hidden" name="comment[commentable_id]" value="{{ $response->id }}">
    <input type="hidden" name="comment[commentable_type]" value="{{ snake_case(class_basename($response)) }}">

    @form_group([
        'text'     => __('addworking.mission.proposal_response.status._final_validation.comment'),
        'type'     => "textarea",
        'name'     => "comment.content",
        'required' => true,
        'rows'     => 10
    ])

    @form_group([
        'text'     => __('addworking.mission.proposal_response.status._final_validation.visibility'),
        'type'     => "select",
        'name'     => "comment.visibility",
        'options'  => array_trans(array_mirror(comment()::getAvailableVisibilities()), 'messages.comment.visibility.'),
        'required' => true,
        'help'     => __('addworking.mission.proposal_response.status._final_validation.audience_text'),
    ])

    @can('close', $response->proposal->offer)
        @form_group([
            'text'  => __('addworking.mission.proposal_response.status._final_validation.close_assignment'),
            'type'  => "checkbox",
            'name'  => "close_mission_offer",
            'value' => 1,
        ])
    @endcan
@endcomponent
