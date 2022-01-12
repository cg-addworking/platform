<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">

<li>

<li>
    <a href="{{ document([])->enterprise()->associate($vendor_enterprise)->routes->index }}">
        <i class="text-muted mr-3 fa fa-file"></i>{{ __('addworking.enterprise.enterprise_vendors._actions.see_documents') }}
    </a>
</li>

@can('index', [passwork(), $vendor_enterprise])
    <li>
        @if(subdomain('sogetrel'))
            <a href="{{ route('sogetrel.passwork.show', $vendor_enterprise->signatories->first()->sogetrelPasswork) }}">
                <i class="text-muted mr-3 fa fa-black-tie"></i> {{ __('addworking.enterprise.enterprise_vendors._actions.see_passwork') }}
            </a>
        @else
            <a href="{{ route('addworking.common.enterprise.passwork.index', $vendor_enterprise) }}">
                <i class="text-muted mr-3 fa fa-black-tie"></i> {{ __('addworking.enterprise.enterprise_vendors._actions.see_passworks') }}
            </a>
        @endif
    </li>
@endcan

<li role="separator" class="divider"></li>
<li>
    <a href="#" onclick="confirm('Confirmer le déréférencement de ce prestataire?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
        @icon('unlink|color:danger|mr:3') <span class="text-danger">{{ __('addworking.enterprise.enterprise_vendors._actions.dereference') }}</span>
    </a>

    @push('modals')
        <form name="{{ $name }}" action="{{ route('management.vendor.remove', ['customer' => $enterprise, 'vendor' => $vendor_enterprise]) }}">
            @csrf
        </form>
    @endpush
</li>

    </div>
</div>
