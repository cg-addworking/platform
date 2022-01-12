@component('components.form.modal', [
                'id' => "proposal-interested-{$proposal->id}",
                'action' => $proposal->routes->status . '?back'
             ])
    @slot('title')
        {{ __('addworking.mission.proposal.status._interested.information_req') }}
    @endslot

    <input type="hidden" name="proposal[status]" value="{{ mission_proposal()::STATUS_INTERESTED }}">
    <input type="hidden" name="comment[commentable_id]" value="{{ $proposal->id }}">
    <input type="hidden" name="comment[commentable_type]" value="{{ snake_case(class_basename($proposal)) }}">

    @form_group([
        'text'     => __('addworking.mission.proposal.status._interested.information_requested'),
        'type'     => "textarea",
        'name'     => "comment.content",
        'required' => true,
        'rows'     => 10
    ])

    @form_group([
        'text'     => __('addworking.mission.proposal.status._interested.visibility'),
        'type'     => "select",
        'name'     => "comment.visibility",
        'options'  => array_trans(array_mirror(comment()::getAvailableVisibilities()), 'messages.comment.visibility.'),
        'value'    => comment()::VISIBILITY_PUBLIC,
        'required' => true,
        'help'     => __('addworking.mission.proposal.status._interested.audience_text'),
    ])
@endcomponent
