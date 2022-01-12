@component('components.form.modal', [
    'id'     => 'passwork-accepted-queued-modal',
    'action' => route('sogetrel.passwork.status', $passwork),
])
    @slot('title')
        {{ __('sogetrel.user.passwork.modals._accepted_passwork_queued.title') }}
    @endslot

    @csrf
    @method('put')

    <input type="hidden" name="status" value="{{ sogetrel_passwork()::STATUS_ACCEPTED_QUEUED }}">
    <input type="hidden" name="passwork_id" value="{{ $passwork->id }}">
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

    <input type="hidden" name="comment[commentable_id]" value="{{ $passwork->id }}">
    <input type="hidden" name="comment[commentable_type]" value="{{ snake_case(class_basename($passwork)) }}">
    <input type="hidden" name="comment[visibility]" value="public">

    @form_group([
        'text'     => __('sogetrel.user.passwork.modals._accepted_passwork_queued.comments'),
        'type'     => "textarea",
        'name'     => "comment.content",
        'required' => false,
        'rows'     => 10
    ])
@endcomponent
