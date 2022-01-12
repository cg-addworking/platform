@component('mail::message')

# @lang('messages.confirmation.title', ['Name' => $user->name])

@lang('messages.confirmation.click_the_button', ['name' => config('app.name')])

@component('mail::button', ['url' => $url])
@lang('messages.confirmation.confirm')
@endcomponent

@lang('messages.confirmation.copy_paste')

    {{ $url }}

@lang('messages.confirmation.thank_you', ['name' => config('app.name')])
<br>
@lang('messages.confirmation.signature', ['name' => config('app.name')])

@endcomponent
