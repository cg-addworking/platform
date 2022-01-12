@component('components.form.modal', [
    'id' => "reject-proposal-response-{$response->id}",
    'action' => route('enterprise.offer.proposal.response.status', [$response->proposal->offer->customer, $response->proposal->offer, $response->proposal, $response]) . '?back']
    )
    @slot('title')
        {{ __('addworking.mission.proposal_response.status._reject.refuse_assign_offer') }}
    @endslot

    <input type="hidden" name="response[status]" value="{{ proposal_response()::STATUS_REFUSED }}">

    @form_group([
        'type' => 'select',
        'name' => "response.reason_for_rejection",
        'required' => true,
        'options' => array_trans(array_mirror(proposal_response()::getAvailableReasonForRejection()), 'mission.response.reason_for_rejection.'),
        'text' => "Motif de refus",
    ])

    <input type="hidden" name="comment[commentable_id]" value="{{ $response->id }}">
    <input type="hidden" name="comment[commentable_type]" value="{{ snake_case(class_basename($response)) }}">

    @form_group([
        'text'     => __('addworking.mission.proposal_response.status._reject.comment'),
        'type'     => "textarea",
        'name'     => "comment.content",
        'required' => true,
        'rows'     => 10
    ])

    @form_group([
        'text'     => __('addworking.mission.proposal_response.status._reject.visibility'),
        'type'     => "select",
        'name'     => "comment.visibility",
        'options'  => array_trans(array_mirror(comment()::getAvailableVisibilities()), 'messages.comment.visibility.'),
        'required' => true,
        'help'     => __('addworking.mission.proposal_response.status._reject.audience_text'),
    ])
@endcomponent