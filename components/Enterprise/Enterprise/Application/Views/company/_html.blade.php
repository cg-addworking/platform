@inject('companyRepository', "Components\Enterprise\Enterprise\Application\Repositories\CompanyRepository")
<div class="container">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @component('bootstrap::attribute', ['label' => __('company::company.show.company.short_id')])
                                {{$company->getShortId()}}
                            @endcomponent
                        </div>
                        <div class="col-md-4">
                            @component('bootstrap::attribute', ['label' => __('company::company.show.company.identification_number')])
                                {{$company->getIdentificationNumber()}}
                            @endcomponent
                        </div>
                        <div class="col-md-4">
                            @component('bootstrap::attribute', ['label' => __('company::company.show.company.legal_form')])
                                {{$company->getLegalForm()->getDisplayName()}} @if($company->getIsSoleShareholder())
                                    ({{ __('company::company.show.company.is_sole_shareholder') }}) @endif
                            @endcomponent
                        </div>
                        <div class="col-md-4">
                            @component('bootstrap::attribute', ['label' => __('company::company.show.company.share_capital')])
                                {{ $companyRepository->getShareCapital($company) }}
                            @endcomponent
                        </div>
                        <div class="col-md-4">
                            @component('bootstrap::attribute', ['label' => __('company::company.show.company.creation_date')])
                                @date($company->getCreationDate())
                            @endcomponent
                        </div>
                        <div class="col-md-4">
                            @component('bootstrap::attribute', ['label' => __('company::company.show.company.cessation_date')])
                                @date($company->getCessationDate())
                            @endcomponent
                        </div>
                        @foreach($company->getInvoicingDetails() as $invoicing_detail)
                            <div class="col-md-4">
                                @component('bootstrap::attribute', ['label' => __('company::company.show.invoicing_detail.vat_number')])
                                    {{ $invoicing_detail->getVatNumber() }}  @if($invoicing_detail->getVatExemption()) -
                                    <span class="text-danger">{{ __('company::company.show.invoicing_detail.vat_exemption') }}</span> @endif
                                @endcomponent
                            </div>
                            <div class="col-md-4">
                                @component('bootstrap::attribute', ['label' => __('company::company.show.invoicing_detail.accounting_year_end_date')])
                                    {{ $invoicing_detail->getAccountingYearEndDate() }}
                                @endcomponent
                            </div>
                            <hr>
                        @endforeach
                        <div class="col-md-4">
                            @component('bootstrap::attribute', ['label' => __('company::company.show.company.last_updated_at')])
                                @date($company->getLastUpdatedAt()) ({{ $company->getOriginData() }})
                            @endcomponent
                        </div>
                        <div class="col-md-8">
                            @component('bootstrap::attribute', ['label' => __('company::company.show.company_registration_organizations.card_title')])
                                @foreach($company->getRegistrationOrganizations() as $company_registration_organizations)
                                    @continue($company_registration_organizations->getOrganization()->getCode() == 'inconnu')
                                    {{ $company_registration_organizations->getOrganization()->getName() }}
                                    ({{ $company_registration_organizations->getOrganization()->getAcronym() }} - {{ $company_registration_organizations->getOrganization()->getCode() }})
                                    {{ $company_registration_organizations->getOrganization()->getLocation() }}
                                    ({{ $company_registration_organizations->getOrganization()->getCountry()->getCode() }}),
                                    {{ __('company::company.show.company_registration_organizations.registred_at') }} @date($company_registration_organizations->getRegisteredAt())
                                    @if(! is_null($company_registration_organizations->getDelistedAt())) <span class="text-danger">{{ __('company::company.show.company_registration_organizations.delisted_at') }} @date($company_registration_organizations->getDelistedAt())</span> @endif
                                    <br>
                                @endforeach
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        @foreach($company->getEstablishments() as $establishment)
                            <div class="col-md-12">
                                @component('bootstrap::attribute', ['label' => __('company::company.show.company_establishments.establishments')])
                                    <div>
                                        {{ __('company::company.show.company_establishments.is_headquarter') }} @if($establishment->getIsHeadquarter())<span class="badge badge-pill badge-success">Oui</span> @else <span class="badge badge-pill badge-danger">Non</span> @endif<br>
                                        {{ $establishment->getIdentificationNumber() }}<br>
                                        {{ $establishment->getFullAddress() }}<br>
                                        {{ __('company::company.show.company_establishments.creation_date') }} :
                                        @date($establishment->getCreationDate())<br>
                                        @if(! is_null($establishment->getCessationDate())) <span class="text-danger">{{ __('company::company.show.company_establishments.cessation_date') }} : @date($establishment->getCessationDate())</span><br>@endif
                                        <a href="https://api.avis-situation-sirene.insee.fr/identification/pdf/{{ $establishment->getIdentificationNumber() }}" target="_blank" class="btn btn-outline-primary btn-sm mt-2">{{ __('company::company.show.company_establishments.sirene') }}</a>
                                        <a href="https://www.societe.com/cgi-bin/search?champs={{ $establishment->getIdentificationNumber() }}" target="_blank" class="btn btn-outline-primary btn-sm mt-2">{{ __('company::company.show.company_establishments.societecom') }}</a>
                                    </div>
                                @endcomponent
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        @foreach($company->getActivities() as $company_activities)
                            <div class="col-md-12">
                                @component('bootstrap::attribute', ['label' => __('company::company.show.company_activities.social_object')])
                                    {{ $company_activities->getSocialObject() ?? 'n/a'}}
                                @endcomponent
                            </div>
                            <div class="col-md-6">
                                @component('bootstrap::attribute', ['label' => __('company::company.show.company_activities.name')])
                                    {{ $company_activities->getActivity()->getName() }} ({{ $company_activities->getActivity()->getCode() }})
                                @endcomponent
                            </div>
                            <div class="col-md-6">
                                @component('bootstrap::attribute', ['label' => __('company::company.show.company_activities.domaine')])
                                    {{$company_activities->getActivity()->getDomaine()}}
                                @endcomponent
                            </div>
                            <div class="col-md-6">
                                @component('bootstrap::attribute', ['label' => __('company::company.show.company_activities.starts_at')])
                                    @date($company_activities->getStartsAt())
                                @endcomponent
                            </div>
                            <div class="col-md-6">
                                @component('bootstrap::attribute', ['label' => __('company::company.show.company_activities.sector_display_name')])
                                    {{optional($company_activities->getActivity()->getSector())->getDisplayName()}}
                                @endcomponent
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        @foreach($company->getLegalRepresentatives() as $company_legal_representatives)
                            @if($company_legal_representatives->getIdentificationNumber())
                                <div class="col-md-6">
                                    @component('bootstrap::attribute', ['label' => __('company::company.show.company_legal_representatives.legal_representative')])
                                        <div>
                                            {{$company_legal_representatives->getQuality()}}<br>
                                            {{$company_legal_representatives->getDenomination()}}<br>
                                            {{ __('company::company.show.company_legal_representatives.identification_number') }}
                                            : {{ $company_legal_representatives->getIdentificationNumber() }}<br>
                                            {{ __('company::company.show.company_legal_representatives.starts_at') }}
                                            @date($company_legal_representatives->getStartsAt())
                                            @if(! is_null($company_legal_representatives->getEndsAt()))
                                                <br> {{ __('company::company.show.company_legal_representatives.ends_at') }}
                                                @date($company_legal_representatives->getEndsAt()) @endif
                                            {{$company_legal_representatives->getFullAddress()}}
                                        </div>
                                    @endcomponent
                                </div>
                            @else
                                <div class="col-md-6">
                                    @component('bootstrap::attribute', ['label' => __('company::company.show.company_legal_representatives.legal_representative')])
                                        <div>
                                            {{$company_legal_representatives->getQuality()}}<br>
                                            {{$company_legal_representatives->getFirstName()}} {{$company_legal_representatives->getLastName()}}
                                            <br>
                                            {{ __('company::company.show.company_legal_representatives.birth_date') }}
                                            @date($company_legal_representatives->getDateBirth())<br>
                                            @if(! is_null($company_legal_representatives->getCountryNationality()))
                                                Nationalité
                                                : {{ $company_legal_representatives->getCountryNationality()->getCode() }}
                                                <br>@endif
                                            {{ __('company::company.show.company_legal_representatives.starts_at') }}
                                            @date($company_legal_representatives->getStartsAt())
                                            @if(! is_null($company_legal_representatives->getEndsAt()))
                                                <br>{{ __('company::company.show.company_legal_representatives.ends_at') }}
                                                @date($company_legal_representatives->getEndsAt()) @endif
                                        </div>
                                    @endcomponent
                                </div>
                            @endif
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        @foreach($company->getEmployees() as $company_employee)
                            <div class="col-md-12">
                                @component('bootstrap::attribute', ['label' => __('company::company.show.company_employees.number')])
                                    <div>
                                        {{ $company_employee->getYear() }}
                                        : {{ $company_employee->getNumber() }} {{ __('company::company.show.company_employees.employee') }}
                                        ({{ __('company::company.show.company_employees.range') }} {{ $company_employee->getRange() }}
                                        )
                                    </div>
                                @endcomponent
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>