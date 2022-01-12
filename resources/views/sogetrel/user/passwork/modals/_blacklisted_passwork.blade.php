@component('components.form.modal', [
    'id'     => "passwork-blacklisted-modal",
    'action' => route('sogetrel.passwork.status', $passwork),
    'show_footer'   => true
])
    @slot('title')
        {{ __('sogetrel.user.passwork.modals._blacklisted_passwork.title') }}
    @endslot

    @csrf
    @method('put')

    <input type="hidden" name="comment[commentable_id]" value="{{ $passwork->id }}">
    <input type="hidden" name="comment[commentable_type]" value="{{ snake_case(class_basename($passwork)) }}">
    <input type="hidden" name="comment[visibility]" value="public">
    <input type="hidden" name="status" value="{{ sogetrel_passwork()::STATUS_BLACKLISTED }}">

    <p><b style="color: red;" >{{ __('sogetrel.user.passwork.modals._blacklisted_passwork.text_line1') }}</b></p>
    <p>{{ __('sogetrel.user.passwork.modals._blacklisted_passwork.text_line2') }}</p>
    <p><b>{{ __('sogetrel.user.passwork.modals._blacklisted_passwork.text_line3') }}</b></p>

    @form_group([
        'text'     => __('sogetrel.user.passwork.modals._blacklisted_passwork.comments'),
        'type'     => "textarea",
        'name'     => "comment.content",
        'required' => false,
        'rows'     => 10
    ])

    @slot('footer')
        <button type="submit" name="passwork-blacklisted" class="btn btn-danger mr-2">{{ __('sogetrel.user.passwork.modals._blacklisted_passwork.yes_blacklist_profile') }}</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('sogetrel.user.passwork.modals._blacklisted_passwork.cancel') }}</button>
    @endslot
@endcomponent
