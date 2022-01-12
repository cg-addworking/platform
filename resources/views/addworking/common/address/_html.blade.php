{{ $address->address }}<br>

@if ($address->additionnal_address)
    {{$address->additionnal_address}}<br>
@endif

{{$address->zipcode}} {{$address->town}}
