<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle mr-2" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{array_get(inbound_invoice()::getAvailableComplianceStatuses(true), $inbound_invoice->compliance_status)}}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">
        @foreach(array_except(inbound_invoice()::getAvailableComplianceStatuses(true), [$inbound_invoice->compliance_status]) as $key => $value)
            @php
                $icon = 'info'; // initialisation
                if ( $key == inbound_invoice()::COMPLIANCE_STATUS_PENDING) $icon = 'hourglass-half';
                if ( $key == inbound_invoice()::COMPLIANCE_STATUS_VALID) $icon = 'check';
                if ( $key == inbound_invoice()::COMPLIANCE_STATUS_INVALID) $icon = 'times';
            @endphp

            <a class="dropdown-item" href="#" onclick="confirm('Confirmer le changement de conformité administrative ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                @icon("{$icon}|mr:3|color:muted") {{$value}}
            </a>

            @push('modals')
                <form name="{{ $name }}" action="{{ $inbound_invoice->routes->compliance_status }}" method="POST">
                    <input type="hidden" name="inbound_invoice[compliance_status]" value="{{$key}}"/>
                    @method('PATCH')
                    @csrf
                </form>
            @endpush
        @endforeach
    </div>
</div>
