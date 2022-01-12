@forelse ($enterprise->phoneNumbers as $phone_number)
    <a href="tel:{{ $phone_number->number }}">{{ $phone_number->number }}</a>
    @unless ($loop->last)
        <br>
    @endunless
@empty
    n/a
@endforelse
