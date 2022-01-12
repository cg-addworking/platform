@component('components.form.modal', [
    'id' => "interview-requested-proposal-response-{$response->id}",
    'action' => route('enterprise.offer.proposal.response.status', [$response->proposal->offer->customer, $response->proposal->offer, $response->proposal, $response]) . '?back']
    )
    @slot('title')
        {{ __('addworking.mission.proposal_response.status._interview_requested.change_resp_status') }}: @lang("mission.response.status.interview_requested")
    @endslot

    <input type="hidden" name="response[status]" value="{{ proposal_response()::STATUS_INTERVIEW_REQUESTED }}">
    <input type="hidden" name="comment[commentable_id]" value="{{ $response->id }}">
    <input type="hidden" name="comment[commentable_type]" value="{{ snake_case(class_basename($response)) }}">

    @form_group([
        'text'     => __('addworking.mission.proposal_response.status._interview_requested.comment'),
        'type'     => "textarea",
        'name'     => "comment.content",
        'required' => true,
        'rows'     => 10
    ])

    @form_group([
        'text'     => __('addworking.mission.proposal_response.status._interview_requested.visibility'),
        'type'     => "select",
        'name'     => "comment.visibility",
        'options'  => array_trans(array_mirror(comment()::getAvailableVisibilities()), 'messages.comment.visibility.'),
        'required' => true,
        'help'     => __('addworking.mission.proposal_response.status._interview_requested.audience_text'),
    ])
@endcomponent