@forelse ($enterprise->addresses as $address)
    @include('addworking.common.address._one_line')
    @support
        <a class="btn btn-sm btn-outline-danger" href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('trash|mr-3')
        </a>
        @push('forms')
            <form name="{{ $name }}" action="{{route('address.detach', [$address, $enterprise])}}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        @endpush
    @endsupport

    @unless($loop->last)
        <br>
    @endunless
@empty
    n/a
@endforelse
