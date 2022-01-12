@extends("layouts/app")

@section('id', 'address-index')

@section('content')
@component('components.panel')
    <h1 class="mb-0">{{ __('addworking.common.address.index.title') }}</h1>
@endcomponent

@foreach ($addresses as $address)
    @component('components.panel')
        {!! $address !!}
    @endcomponent
@endforeach
@endsection
