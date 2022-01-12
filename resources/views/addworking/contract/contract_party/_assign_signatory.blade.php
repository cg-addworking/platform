@form_group([
    'text'     => __('addworking.contract.contract_party._assign_signatory.signatory'),
    'type'     => "select",
    'name'     => "contract_party.user",
    'required' => true,
    'options'  => Repository::contractParty()
        ->getAvailableSignatories($contract_party)
        ->pluck('name', 'id'),
])
