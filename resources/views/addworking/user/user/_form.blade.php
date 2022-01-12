@if ($user->exists)
    <input type="hidden" name="user[id]" value="{{ $user->id }}">
@endif

<div class="row">
    <div class="col-md-2">
        @component('components.form.group', ['type' => 'select', 'name' => 'user.gender', 'value' => $user->gender, 'values' => array_trans(array_mirror(user()::getAvailableGenders()), 'messages.gender.'), 'required' => true])
            @slot('label')
                @lang('user.user.gender')
            @endslot
        @endcomponent
    </div>

    <div class="col-md-5">
        @component('components.form.group', ['name' => 'user.firstname', 'value' => $user->firstname, 'required' => true])
            @slot('label')
                @lang('user.user.firstname')
            @endslot

            @slot('placeholder')
                {{ __('addworking.user.user._form.first_name') }}
            @endslot
        @endcomponent
    </div>
    <div class="col-md-5">
        @component('components.form.group', ['name' => 'user.lastname', 'value' => $user->lastname, 'required' => true])
            @slot('label')
                @lang('user.user.lastname')
            @endslot

            @slot('placeholder')
                {{ __('addworking.user.user._form.last_name') }}
            @endslot
        @endcomponent
    </div>
</div>

@component('components.form.group', ['type' => 'email', 'name' => 'user.email', 'value' => $user->email, 'required' => true])
    @slot('label')
        @lang('user.user.email')
    @endslot
@endcomponent
