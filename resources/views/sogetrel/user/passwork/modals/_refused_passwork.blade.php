@component('components.form.modal', [
    'id'     => "passwork-refused-modal",
    'action' => route('sogetrel.passwork.status', $passwork),
    'show_footer'   => true
])
    @slot('title')
        {{ __('sogetrel.user.passwork.modals._refused_passwork.title') }}
    @endslot

    @csrf
    @method('put')

    <input type="hidden" name="status" value="{{ sogetrel_passwork()::STATUS_REFUSED }}">
    <input type="hidden" name="comment[commentable_id]" value="{{ $passwork->id }}">
    <input type="hidden" name="comment[commentable_type]" value="{{ snake_case(class_basename($passwork)) }}">
    <input type="hidden" name="comment[visibility]" value="public">

    @form_group([
        'text'     => __('sogetrel.user.passwork.modals._refused_passwork.comments'),
        'type'     => "textarea",
        'name'     => "comment.content",
        'required' => false,
        'rows'     => 10
    ])
@endcomponent
