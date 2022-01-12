@if ($phoneNumber->id)
    <input type="hidden" name="phone_number.id" value="{{ $phoneNumber->id }}">
@endif

@component('components.form.group', ['name' => 'phone_number.number', 'value' => $phoneNumber->number, 'required' => true])
    @slot('label')
        {{ __('addworking.common.phone_number._form.number') }}
    @endslot

    @slot('placeholder')
        {{ __('addworking.common.phone_number._form.number_placeholder') }}
    @endslot
@endcomponent

@component('components.form.group', ['type' => 'textarea', 'name' => 'phone_number.note', 'value' => $phoneNumber->note])
    @slot('label')
        {{ __('addworking.common.phone_number._form.note') }}
    @endslot

    @slot('placeholder')
        {{ __('addworking.common.phone_number._form.note_placeholder') }}
    @endslot
@endcomponent
