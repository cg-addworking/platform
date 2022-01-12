@inject('contractRepository', 'Components\Contract\Contract\Application\Repositories\ContractRepository')

<div class="dropdown">
    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('addworking.enterprise.vendor._actions.action') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">
        @can('index', [document(), $vendor])
            <a class="dropdown-item" href="{{ document([])->enterprise()->associate($vendor)->routes->index }}">
                @icon('file-alt|color:muted|mr:3') {{ __('addworking.enterprise.vendor._actions.consult_document') }}
            </a>
        @endcan

        @can('index', $contractRepository->make())
            <a class="dropdown-item" href="{{ route('contract.index') }}?filter[parties]={{ $vendor->id }}">
                @icon('file-contract|color:muted|mr:3') {{ __('addworking.enterprise.vendor._actions.consult_contract') }}
            </a>
        @endcan
        @if($enterprise->is_customer && !auth::user()->isSupport())
            <a class="dropdown-item" href="{{ route('inbound_invoice.index_customer')}}?filter[vendors][]={{ $vendor->id }}">
                @icon('file-invoice-dollar|color:muted|mr:3') {{ __('addworking.enterprise.vendor._actions.consult_invoice') }}
            </a>
        @endif
        @can('viewAnyBillingDeadlineVendor', [$enterprise, $vendor])
            @action_item(sprintf(__('addworking.enterprise.vendor._actions.billing_options')."|href:%s|icon:hourglass-half", route('addworking.enterprise.vendor.billing_deadline.index', @compact('enterprise', 'vendor'))))
        @endcan

        @if(subdomain('sogetrel'))
            @if($vendor->signatories->first()->sogetrelPasswork->exists)
                <a href="{{ route('sogetrel.passwork.show', $vendor->signatories->first()->sogetrelPasswork) }}">
                    @icon('id-card|color:muted|mr:3') {{ __('addworking.enterprise.vendor._actions.consult_passwork') }}
                </a>
            @endif
        @else
            @can('index', [$enterprise, passwork()])
                <a class="dropdown-item" href="{{ route('addworking.common.enterprise.passwork.index', $vendor) }}">
                    @icon('id-card|color:muted|mr:3') {{ __('addworking.enterprise.vendor._actions.consult_passwork') }}
                </a>
            @endcan
        @endif

        @can('detachVendor', $enterprise)
            <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="confirm('{{ __('addworking.enterprise.vendor._actions.confirm_delisting_of_service_provider') }}') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                    @icon('unlink|color:danger|mr:3') <span class="text-danger">{{ __('addworking.enterprise.vendor._actions.dereference') }}</span>
                </a>

                @push('modals')
                    <form name="{{ $name }}" action="{{ route('addworking.enterprise.vendor.detach', [$enterprise, $vendor]) }}">
                        @csrf
                    </form>
                @endpush
        @endcan
    </div>
</div>
