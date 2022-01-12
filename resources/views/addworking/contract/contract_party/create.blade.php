@extends('foundation::layout.app.create', ['action' => $contract_party->routes->store])

@section('title', __('addworking.contract.contract_party.create.add_stakeholder'))

@section('toolbar')
    @button(__('addworking.contract.contract_party.create.return')."|href:{$contract_party->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    {{ $contract_party->views->breadcrumb(['page' => "create"])}}
@endsection

@section('form')
    @inject('repo', 'App\Repositories\Addworking\Contract\ContractPartyRepository')

    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h5">@icon('info') Entreprise Partie Prennante au Contrat</legend>

        @component('bootstrap::form.group', ['text' => __('addworking.contract.contract_party.create.enterprise'), 'required' => true])
            <select name="contract_party[enterprise]" class="form-control selectpicker" required data-live-search="true">
                <option value="{{ $contract_party->contract->enterprise->id }}">
                    {{ __('addworking.contract.contract_party.create.my_enterprise') }} ({{ $contract_party->contract->enterprise->name }})
                </option>
                @if(Repository::addworkingEnterprise()->isAddworking($contract_party->contract->enterprise))
                    <optgroup label="Prestataires">
                        @foreach(Repository::vendor()->getAvailableVendors() as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Clients">
                        @foreach(Repository::customer()->getAvailableCustomers() as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </optgroup>
                @else
                    @if(count($enterprises = $repo->getAvailableSubsidiaries($contract_party)))
                        <optgroup label="Mes Filliales">
                            @foreach($enterprises as $enterprise)
                                <option value="{{ $enterprise->id }}">{{ $enterprise->name }}</option>
                            @endforeach
                        </optgroup>
                    @endif
                    @if(count($enterprises = $repo->getAvailableVendors($contract_party)))
                        <optgroup label="Mes Prestataires">
                            @foreach($enterprises as $enterprise)
                                <option value="{{ $enterprise->id }}">{{ $enterprise->name }}</option>
                            @endforeach
                        </optgroup>
                    @endif
                    @if(count($enterprises = $repo->getAvailableCustomers($contract_party)))
                        <optgroup label="Mes Clients">
                            @foreach($enterprises as $enterprise)
                                <option value="{{ $enterprise->id }}">{{ $enterprise->name }}</option>
                            @endforeach
                        </optgroup>
                    @endif
                @endif
            </select>
        @endcomponent

        @form_group([
            'text'     => __('addworking.contract.contract_party.create.denomination'),
            'name'     => "contract_party.denomination",
            'required' => true,
            'help'     => __('addworking.contract.contract_party.create.help_text'),
        ])
    </fieldset>


    @button(__('addworking.contract.contract_party.create.create')."|icon:save|type:submit")
@endsection
