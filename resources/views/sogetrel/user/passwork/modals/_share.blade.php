@component('components.form.modal', [
    'id'     => 'share-modal',
    'action' => route('sogetrel.passwork.share', $passwork),
    'submit' => "Envoyer"

])
    @slot('title')
        {{ __('sogetrel.user.passwork.modals._share.title') }}
    @endslot

    @csrf
    @method('post')

    @form_group([
        'type'         => "select",
        'text'         => __('sogetrel.user.passwork.modals._share.recipient_select'),
        'name'         => "users.",
        'options'      => sogetrel_passwork()::getAvailableSharingRecipients(),
        'selectpicker' => true,
        'multiple'     => true,
        'search'       => true,
        'required'     => true,
    ])

    @php
        session()->forget('_old_input.comment')
    @endphp

    @form_group ([
        'type'     => "text",
        'name'     => "comment",
        'required' => false,
        'text'     => __('sogetrel.user.passwork.modals._share.add_remark'),
    ])

    <div class="form-group pt-3">
        <div class="checkbox">
            <label><input type="checkbox" name="passwork_sharing_report" checked>{{ __('sogetrel.user.passwork.modals._share.send_me_copy') }}</label>
        </div>
    </div>
@endcomponent
