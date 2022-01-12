@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            @if(isset($logo) && $logo->exists)
                <img style="height:120px" src="{{ route('file.logo', $logo) }}" alt="{{$logo->logoEnterprise->name}}">
            @endif
            <img style="height:120px" src="{{ asset('img/logo_addworking_vertical.png') }}" alt="addworking.com La Solution #ReadyToWork">
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
