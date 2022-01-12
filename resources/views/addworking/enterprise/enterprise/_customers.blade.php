@forelse ($enterprise->customers as $customer)
    {{ $customer->views->link }}
    @unless($loop->last)
        <br>
    @endunless
@empty
    n/a
@endforelse
