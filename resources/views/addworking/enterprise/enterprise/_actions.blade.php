@inject('contractRepository', 'Components\Contract\Contract\Application\Repositories\ContractRepository')
@inject('userRepository', 'Components\Contract\Contract\Application\Repositories\UserRepository')
@inject('passworkEnterpriseRepository', 'App\Repositories\Sogetrel\Enterprise\PassworkEnterpriseRepository')
@inject('sogetrelEnterpriseRepository', 'App\Repositories\Sogetrel\Enterprise\SogetrelEnterpriseRepository')

@component('foundation::layout.app._actions', ['model' => $enterprise])
    @can('index', [job(), $enterprise])
        <a class="dropdown-item" href="{{ job([])->enterprise()->associate($enterprise)->routes->index }}">
            @icon('user-tie|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.trades') }}
        </a>
    @endcan

    @if (! $enterprise->isVendor())
        <a class="dropdown-item" href="{{ site([])->enterprise()->associate($enterprise)->routes->index }}">
            @icon('building|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.sites') }}
        </a>
    @endif

    @can('indexMember', $enterprise)
        <a class="dropdown-item" href="{{ route('addworking.enterprise.member.index', $enterprise) }}">
            @icon('user-cog|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.membership_management') }}
        </a>
    @endcan
    @can('index', ['Components\Enterprise\Resource\Application\Models\Resource', $enterprise])
        <a class="dropdown-item" href="{{ route('addworking.enterprise.resource.index', $enterprise) }}">
            @icon('users-cog|mr:3|color:muted') {{ __('addworking.enterprise.enterprise._actions.resource_management') }}
        </a>
    @endcan
    @support
        <a class="dropdown-item" href="{{ document([])->enterprise()->associate($enterprise)->routes->index }}">
            @icon('file-alt|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.documents') }}
        </a>

        <a class="dropdown-item" href="{{ document_type([])->enterprise()->associate($enterprise)->routes->index }}">
            @icon('file-medical|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.document_management') }}
        </a>

        <a class="dropdown-item" href="{{ route('subsidiaries.index', $enterprise) }}">
            @icon('building|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.subsidiaries') }}
        </a>

        <a class="dropdown-item" href="{{ route('addworking.enterprise.vendor.index', $enterprise) }}">
            @icon('users|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.providers') }}
            <span class="badge badge-primary">{{ $enterprise->vendors()->count() }}</span>
        </a>

        <a class="dropdown-item" href="{{ route('addworking.enterprise.vendor.attach', $enterprise) }}">
            @icon('building|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.refer_service_provider') }}
        </a>

        <a class="dropdown-item" href="{{ route('addworking.enterprise.member.create', $enterprise) }}">
            @icon('user-tag|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.refer_user') }}
        </a>
    @endsupport
        @if (! $enterprise->isVendor() || Auth::user()->isSupport())
            @can('index', $contractRepository->make())
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ $userRepository->isSupport($userRepository->connectedUser()) ? route('support.contract.index.enterprise', $enterprise) : route('contract.index') }}">
                    @icon('file-contract|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.contracts') }}
                </a>
            @endcan
        @endif

        @if ($enterprise->isVendor() && ! Auth::user()->isSupport())
            @can('index', $contractRepository->make())
                <a class="dropdown-item" href="{{ route('contract.index') }}?filter[parties]={{ $enterprise->id }}">
                    @icon('file-contract|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.consult_contract') }}
                </a>
            @endcan
            @can('index', [document(), $enterprise])
                <a class="dropdown-item" href="{{ document([])->enterprise()->associate($enterprise)->routes->index }}">
                    @icon('file-alt|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.consult_document') }}
                </a>
            @endcan
            <a class="dropdown-item" href="{{ route('inbound_invoice.index_customer')}}?filter[vendors][]={{ $enterprise->id }}">
                @icon('file-invoice-dollar|color:muted|mr:3')  {{ __('addworking.enterprise.enterprise._actions.consult_invoice') }}
            </a>
            @if($passworkEnterpriseRepository->hasSogetrelPasswork($enterprise)
                && $sogetrelEnterpriseRepository->isSubsidiaryOfSogetrel(Auth::user()->enterprise))
                <a class="dropdown-item" href="{{ route('sogetrel.passwork.show', $passworkEnterpriseRepository->getEnterpriseSogetrelPasswork($enterprise)) }}">
                    @icon('id-card|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.consult_passwork') }}
                </a>
            @else
            @can('index', [$enterprise, passwork()])
                <a class="dropdown-item" href="{{ route('addworking.common.enterprise.passwork.index', $enterprise) }}">
                    @icon('id-card|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.consult_passwork') }}
                </a>
            @endcan
            @endif
        @endif

    @if(!auth()->user()->isSupport() && $enterprise->is_customer)
        @can('index',[accounting_expense(), $enterprise])
            <div class="dropdown-divider"></div>
            <h3 class="dropdown-header" >
                @icon('file-invoice|mr:3|color:muted') {{ __('addworking.enterprise.enterprise._actions.invoicing') }}
            </h3>
            <a class="dropdown-item" style="margin-left: 8px" href="{{ route('addworking.enterprise.accounting_expense.index', $enterprise) }}">
                @icon('cogs|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.accounting_expense') }}
            </a>
        @endcan
    @endif

    @support
        <div class="dropdown-divider"></div>
        <h3 class="dropdown-header" >
            @icon('file-invoice|mr:3|color:muted') {{ __('addworking.enterprise.enterprise._actions.invoicing') }}
        </h3>
        @can('index', [inbound_invoice(), $enterprise])
            <a class="dropdown-item" style="margin-left: 8px" href="{{ inbound_invoice(@compact('enterprise'))->routes->index }}">
                @icon('file-invoice-dollar|mr:3|color:muted') {{ __('addworking.enterprise.enterprise._actions.service_provider_invoices') }}
            </a>
        @endcan
        @if($enterprise->is_customer)
            <a class="dropdown-item" style="margin-left: 8px" href="{{ route("addworking.billing.outbound.index", $enterprise->id) }}">
                @icon('file-invoice|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.addworking_invoice') }}
            </a>
            <a class="dropdown-item" style="margin-left: 8px" href="{{ route('addworking.enterprise.parameter.index', $enterprise->id) }}">
                @icon('cogs|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.billing_settings') }}
            </a>
            @can('index',[accounting_expense(), $enterprise])
                <a class="dropdown-item" style="margin-left: 8px" href="{{ route('addworking.enterprise.accounting_expense.index', $enterprise) }}">
                    @icon('cogs|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.accounting_expense') }}
                </a>
            @endcan
            <div class="dropdown-divider"></div>

            <h3 class="dropdown-header" >
                @icon('money-check|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.payment') }}
            </h3>
            <a class="dropdown-item" style="margin-left: 8px" href="{{ route('addworking.billing.received_payment.index', $enterprise->id) }}">
                @icon('check|mr:3|color:muted') {{ __('addworking.enterprise.enterprise._actions.received_payments') }}
            </a>
            <a class="dropdown-item" style="margin-left: 8px" href="{{ route('addworking.billing.payment_order.index', $enterprise->id) }}">
                @icon('money-check-alt|color:muted|mr:3') {{ __('addworking.enterprise.enterprise._actions.payment_order') }}
            </a>

        @endif
    @endsupport
@endcomponent
