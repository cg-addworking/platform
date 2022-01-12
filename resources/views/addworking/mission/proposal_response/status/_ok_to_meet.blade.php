@component('components.form.modal', [
    'id' => "ok-to-meet-proposal-response-{$response->id}",
    'action' => route('enterprise.offer.proposal.response.status', [$response->proposal->offer->customer, $response->proposal->offer, $response->proposal, $response]) . '?back']
    )
    @slot('title')
        {{ __('addworking.mission.proposal_response.status._ok_to_meet.change_resp_status') }}: @lang("mission.response.status.ok_to_meet")
    @endslot

    <input type="hidden" name="response[status]" value="{{ proposal_response()::STATUS_OK_TO_MEET }}">
    <input type="hidden" name="comment[commentable_id]" value="{{ $response->id }}">
    <input type="hidden" name="comment[commentable_type]" value="{{ snake_case(class_basename($response)) }}">

    @form_group([
        'text'     => __('addworking.mission.proposal_response.status._ok_to_meet.comment'),
        'type'     => "textarea",
        'name'     => "comment.content",
        'required' => true,
        'rows'     => 10
    ])

    @form_group([
        'text'     => __('addworking.mission.proposal_response.status._ok_to_meet.visibility'),
        'type'     => "select",
        'name'     => "comment.visibility",
        'options'  => array_trans(array_mirror(comment()::getAvailableVisibilities()), 'messages.comment.visibility.'),
        'required' => true,
        'help'     => __('addworking.mission.proposal_response.status._ok_to_meet.audience_text'),
    ])
@endcomponent