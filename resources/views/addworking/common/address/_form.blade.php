@if ($address->id)
    <input type="hidden" name="address[id]" value="{{ $address->id }}">
@endif

<input type="hidden" name="enterprise[id]" value="{{ Auth::user()->enterprise->id }}">

<div class="row">
    <div class="col-md-6">
        @component('components.form.group', ['name' => "address.address", 'value' => $address->address, 'required' => true])
            @slot('label')
                @lang('messages.address.address')
            @endslot

            @slot('placeholder')
                @lang('messages.address.address_placeholder')
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', ['name' => "address.additionnal_address", 'value' => $address->additionnal_address])
            @slot('label')
                @lang('messages.address.additionnal_address')
            @endslot

            @slot('placeholder')
                {{ __('addworking.common.address._form.appartment_floor') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', ['name' => "address.zipcode", 'value' => $address->zipcode, 'required' => true])
            @slot('label')
                @lang('messages.address.zipcode')
            @endslot

            @slot('placeholder')
                00000
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', ['name' => "address.town", 'value' => $address->town, 'required' => true])
            @slot('label')
                @lang('messages.address.town')
            @endslot

            @slot('placeholder')
                {{ __('addworking.common.address._form.city_place') }}
            @endslot
        @endcomponent
    </div>

    <div class="col-md-6">
        @component('components.form.group', ['type' => "select", 'name' => "address.country", 'value' => $address->country ?? 'fr', 'values' => ['fr' => 'France']])
            @slot('label')
                @lang('messages.address.country')
            @endslot
        @endcomponent
    </div>
</div>

@section('scripts')
    @parent
    <script>
        $('input[name="address[town]"]').blur(function() {
            $(this).val($(this).val().toUpperCase());
        });
    </script>
@endsection
