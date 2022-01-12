@inject('enterpriseRepository', 'Components\Contract\Contract\Application\Repositories\EnterpriseRepository')
@inject('contractRepository', 'Components\Contract\Contract\Application\Repositories\ContractRepository')
@inject('userRepository', 'Components\Contract\Contract\Application\Repositories\UserRepository')

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('components.contract.contract.application.views.contract_party._form.general_information') }}</legend>
    @foreach($contractRepository->getSignatoryParties($contract)->sortBy('order') as $contract_party)
        <legend class="text-primary h6">@icon('handshake') {{ __('components.contract.contract.application.views.contract_party._form.party') }} : {{$contract_party->getDenomination()}}</legend>
        @form_group([
            'text'     => __('components.contract.contract.application.views.contract_party._form.denomination'),
            'type'     => "text",
            'name'     => "contract_party.{$loop->iteration}.denomination",
            'value'    => $contract_party->getDenomination(),
            'required' => true,
            'disabled' => request()->user()->isSupport() ? false : true,
        ])

         @form_group([
            'text'         => __('components.contract.contract.application.views.contract_party._form.enterprise'),
            'type'         => "select",
            'name'         => "contract_party.{$loop->iteration}.enterprise_id",
            'options'      => $enterprises,
            'selectpicker' => true,
            'search'       => true,
            'required'     => true,
            'id'           => "enterprise-party-{$loop->iteration}",
            'value'        => optional($contract_party->getEnterprise())->getId(),
            'disabled'     => request()->user()->isSupport() ? false : true,
        ])

        @form_group([
            'text'     => __('components.contract.contract.application.views.contract_party._form.signatory'),
            'type'     => "select",
            'name'     => "contract_party.{$loop->iteration}.signatory_id",
            'options'  => ! is_null($contract_party->getEnterprise()) ? $enterpriseRepository->getSignatoriesOf($contract_party->getEnterprise())->pluck('name', 'id') : [],
            'required' => true,
            'id'       => "enterprise-signatory-{$loop->iteration}",
            'value'    => optional($contract_party->getSignatory())->getId(),
            'disabled' => request()->user()->isSupport() || $userRepository->checkIfUserCanChangeContractPartySignatory(request()->user(), $contract) ? false : true,
        ])

        @if(Auth::user()->isSupport()
            && count($contractRepository->getContractParts($contract))
            && !$contractRepository->hasYousignProcedureId($contract))
            @form_group([
                'text'  => __('components.contract.contract.application.views.contract_party._form.signed_at'),
                'type'  => 'date',
                'name'  => "contract_party.{$loop->iteration}.signed_at",
                'value' => optional($contract_party)->getSignedAt(),
            ])
        @endif

        @form_group([
            'text'     => __('components.contract.contract.application.views.contract_party._form.order'),
            'type'     => "text",
            'name'     => "contract_party.{$loop->iteration}.order",
            'value'    => $contract_party->getOrder(),
            'required' => true,
            'disabled' => request()->user()->isSupport() || $userRepository->checkIfUserCanChangeContractPartySignatory(request()->user(), $contract) ? false : true,
        ])

        <input type="hidden" name="contract_party[{{$loop->iteration}}][contract_party_id]" value="{{ $contract_party->getId() }}">
    @endforeach
</fieldset>

@push('scripts')
    <script>
        $(function () {
            var party_data = $('select,input[name^="contract_party"]').serialize();

            $("select[id^='enterprise-party-']").change(function () {
                var part = $(this).attr('id').split('-')[2];
                var value = $(this).val();
                var signatories_select = "enterprise-signatory-" + part;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.get_signatories') }}",
                    data: {
                        enterprise_id: value
                    },
                    beforeSend: function () {
                        $("#" + signatories_select + " option").remove();
                    },
                    success: function(response) {
                        $.each(response.data, function(id, name) {
                            $("#" + signatories_select).append('<option value="'+id+'">'+name+'</option>');
                        });
                    },
                });
            });

            $('form').submit(function(event) {
                if (party_data != $('select,input[name^="contract_party"]').serialize())
                {
                    if(!confirm("{{__('components.contract.contract.application.views.contract_party._form.confirm_edit')}}")) {
                        event.preventDefault();
                        return false;
                    }
                }
            });
        })
    </script>
@endpush
