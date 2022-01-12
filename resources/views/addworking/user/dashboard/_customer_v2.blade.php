@inject('dashboardRepository', 'Components\User\User\Application\Repositories\DashboardRepository')

<div class="pt-5" style="background-color: #F5F5F5">
    <div class="container">
        <div class="align-items-center">
            <div class="row mb-2 ml-1">
                <h1>Bonjour {{ $data['auth_user_firstname'] }},</h1>
            </div>
            <div class="row row-cols-2 row-cols-md-4">
                <div class="col mb-4">
                    <a href="{{ route('addworking.enterprise.vendor.index', $data['auth_user_enterprise']) }}" style="text-decoration: none;">
                        <div class="card h-100 text-center" style="border: none; border-radius: 1em">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><i class="fas fa-users"></i></h5>
                                <p class="card-text font-weight-bold" style="color: #000000;">Mes partenaires</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col mb-4">
                    <a href="{{ route('work_field.index') }}" style="text-decoration: none;">
                        <div class="card h-100 text-center" style="border: none; border-radius: 1em">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><i class="fas fa-gopuram"></i></h5>
                                <p class="card-text font-weight-bold" style="color: #000000;">Mon activité</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col mb-4">
                    <a href="{{ route('contract.index') }}" style="text-decoration: none;">
                        <div class="card h-100 text-center" style="border: none; border-radius: 1em">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><i class="fas fa-hands-helping "></i></h5>
                                <p class="card-text font-weight-bold" style="color: #000000;">Mon business</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col mb-4">
                    <a href="{{ route('addworking.billing.outbound.index', $data['auth_user_enterprise']) }}" style="text-decoration: none;">
                        <div class="card h-100 text-center" style="border: none; border-radius: 1em">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><i class="fas fa-search-dollar"></i></h5>
                                <p class="card-text font-weight-bold" style="color: #000000;">Mes dépenses</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row pt-4">
                <div class="col-md-12">
                    <h3>{{ $data['number_of_contract_to_sign'] }} contrats à signer</h3>
                    <p><small>Les sous-traitants ont déjà signé leur partie. Ces contrats sont en attente de signature pour être finalisés.</small></p>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-sm" style="background: white; border-collapse: collapse; border-radius: 1em; overflow: hidden;">
                            <colgroup>
                                <col width="35%">
                                <col width="20%">
                                <col width="13%">
                                <col width="12%">
                                <col width="15%">
                                <col width="5%">
                            </colgroup>
                            <thead>
                            <tr>
                                <th scope="col" class="p-3">Chantier</th>
                                <th scope="col" class="p-3">Sous-traitant</th>
                                <th scope="col" class="p-3">Date de début</th>
                                <th scope="col" class="p-3">Date de fin</th>
                                <th scope="col" class="p-3"></th>
                                <th scope="col" class="p-3"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($data['contracts_to_sign'] as $to_sign_contract)
                                    <tr>
                                        <th scope="row" class="p-3">{{ $to_sign_contract->work_display_name }}</th>
                                        <td class="p-3">{{ $to_sign_contract->vendor_enterprise_name }}</td>
                                        <td class="p-3">@date(carbon($to_sign_contract->contract_valid_from))</td>
                                        <td class="p-3">@date(carbon($to_sign_contract->contract_valid_until))</td>
                                        <td class="text-primary p-3"><a href="{{ route('contract.sign', [$to_sign_contract->contract_id, $to_sign_contract->contract_next_party_to_sign_id]) }}"><i class="fas fa-signature"> Signer le contrat</i></a></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row pt-4">
                <div class="col-md-10">
                    <h3>{{ $data['number_of_contract_pending'] }} contrats à finaliser par les sous-traitants</h3>
                </div>
                @if($data['number_of_contract_pending'] > 0)
                    <div class="col-md-2" style="text-align: end; margin-top: 15px;"><a href="{{ route('contract.index') }}?filter[states][]=in_preparation&filter[states][]=missing_documents" style="text-decoration: underline; color: #000000;"><span class="font-weight-bold">Voir tout</span></a></div>
                @endif
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-sm" style="background: white; border-collapse: collapse; border-radius: 1em; overflow: hidden;">
                            <colgroup>
                                <col width="35%">
                                <col width="20%">
                                <col width="13%">
                                <col width="12%">
                                <col width="15%">
                                <col width="5%">
                            </colgroup>
                            <thead>
                            <tr>
                                <th scope="col" class="p-3">Chantier</th>
                                <th scope="col" class="p-3">Sous-traitant</th>
                                <th scope="col" class="p-3">Date de début</th>
                                <th scope="col" class="p-3">Date de fin</th>
                                <th scope="col" class="p-3">Etat</th>
                                <th scope="col" class="p-3"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['contracts_pending'] as $pending_contract)
                                <tr>
                                    <th scope="row" class="p-3">{{ $pending_contract->work_display_name }}</th>
                                    <td class="p-3">{{ $pending_contract->vendor_enterprise_name }}</td>
                                    <td class="p-3">@date(carbon($pending_contract->contract_valid_from))</td>
                                    <td class="p-3">@date(carbon($pending_contract->contract_valid_until))</td>
                                    <td class="p-3">
                                        @switch($pending_contract->contract_state)
                                            @case ('in_preparation')
                                                <span class="badge badge-pill badge-info">{{ __("components.contract.contract.application.views.contract._state.in_preparation") }}</span>
                                            @break

                                            @case ('missing_documents')
                                                <span class="badge badge-pill badge-primary">{{ __("components.contract.contract.application.views.contract._state.missing_documents") }}</span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td class="text-primary p-3"><a href="{{ route('contract.show', $pending_contract->contract_id) }}"><i class="fas fa-eye"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
