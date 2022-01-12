<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('addworking.contract.contract_party._form.general_information') }}</legend>

    @form_group([
        'text'     => __('addworking.contract.contract_party._form.denomination'),
        'name'     => "contract_party.denomination",
        'value'    => $contract_party->denomination,
        'required' => true,
    ])

    @form_group([
        'text'     => __('addworking.contract.contract_party._form.signatory'),
        'type'     => "select",
        'name'     => "contract_party.user",
        'required' => true,
        'options'  => Repository::contractParty()
            ->getAvailableSignatories($contract_party)
            ->mapWithKeys(fn($user) => [$user->id => $user->name]),
    ])

    @can('updateSignatoryStatus', $contract_party)
        @form_group([
            'text'     => __('addworking.contract.contract_party._form.has_signed'),
            'type'     => "select",
            'options'  => ['0' => "Non", '1' => "Oui"],
            'name'     => "contract_party.signed",
            'value'    => $contract_party->signed,
        ])

        @form_group([
            'text'     => __('addworking.contract.contract_party._form.signed_on'),
            'type'     => "date",
            'name'     => "contract_party.signed_at",
            'value'    => $contract_party->signed_at,
        ])

        @form_group([
            'text'     => __('addworking.contract.contract_party._form.declined'),
            'type'     => "select",
            'name'     => "contract_party.declined",
            'options'  => ['0' => "Non", '1' => "Oui"],
            'value'    => $contract_party->declined,
        ])

        @form_group([
            'text'     => __('addworking.contract.contract_party._form.declined_on'),
            'type'     => "date",
            'name'     => "contract_party.declined_at",
            'value'    => $contract_party->declined_at,
        ])
    @endcan
</fieldset>
