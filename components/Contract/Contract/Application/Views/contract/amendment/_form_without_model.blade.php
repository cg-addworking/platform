@inject('enterpriseRepository', 'Components\Contract\Contract\Application\Repositories\EnterpriseRepository')
@inject('contractRepository', "Components\Contract\Contract\Application\Repositories\ContractRepository")

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('components.contract.contract.application.views.amendment._form_without_model.contract_informations') }}</legend>
    @form_group([
        'text'        => __('components.contract.contract.application.views.amendment._form_without_model.name'),
        'type'        => "text",
        'name'        => "contract.name",
        'required'    => true,
        'value'       => __('components.contract.contract.application.views.contract._form.amendment_name_preset', [
            'count' => $contract_parent->getAmendments()->count()+1,
            'contract_parent_name' => $contract_parent->getName()
        ]),
    ])

    @form_group([
        'text'        => __('components.contract.contract.application.views.amendment._form_without_model.valid_from'),
        'type'        => "date",
        'name'        => "contract.valid_from",
        'required'    => true,
    ])

    @form_group([
        'text'        => __('components.contract.contract.application.views.amendment._form_without_model.valid_until'),
        'type'        => "date",
        'name'        => "contract.valid_until",
    ])

    @form_group([
        'text'        => __('components.contract.contract.application.views.amendment._form_without_model.external_identifier'),
        'type'        => "text",
        'name'        => "contract.external_identifier",
    ])

    <legend class="text-primary h5">@icon('info') {{ __('components.contract.contract.application.views.amendment._form_without_model.parties_informations') }}</legend>

        @foreach($contractRepository->getSignatoryParties($contract_parent) as $party)
            @form_group([
                'text'        => __('components.contract.contract.application.views.amendment._form_without_model.designation'),
                'type'        => "text",
                'name'        => "contract_party.{$party->getOrder()}.denomination",
                'value'       => $party->getDenomination(),
                'disabled'    => true,
            ])

            @form_group([
                'text'         => __('components.contract.contract.application.views.amendment._form_without_model.enterprise'),
                'type'         => "select",
                'name'         => "contract_party.{$party->getOrder()}.enterprise_id",
                'id'           => "enterprise-party-{$party->getOrder()}",
                'options'      => [ $party->getEnterprise()->id => $party->getEnterprise()->name],
                'value'        => $party->getEnterprise()->id,
                'disabled'     => true,
            ])

            @form_group([
                'text'         => __('components.contract.contract.application.views.amendment._form_without_model.signatory'),
                'type'         => "select",
                'name'         => "contract_party.{$party->getOrder()}.signatory_id",
                'required'     => true,
                'id'           => "enterprise-signatory-{$party->getOrder()}",
                'options'      => $enterpriseRepository->getSignatoriesOf($party->getEnterprise())->pluck('name', 'id'),
                'value'        => $party->getEnterprise(),
                'required'     => true,
            ])

            @form_group([
                'text'        => __('components.contract.contract.application.views.amendment._form_without_model.signed_at'),
                'type'        => "date",
                'name'        => "contract_party.{$party->getOrder()}.signed_at",
                'required'    => true,
                'disabled'    => false,
            ])

            <input type="hidden" name="contract_party[{{$party->getOrder()}}][order]" value="{{ $party->getOrder() }}">
            <input type="hidden" name="contract_party[{{$party->getOrder()}}][contract_party_id]" value="{{ $party->getId() }}">

        @endforeach
        <input type="hidden" name="contract[enterprise]" id="contract-owner-id" value="{{ $contract_parent->getEnterprise()->id }}">
</fieldset>

@include('contract::contract._form_mission')

<fieldset>
    <legend class="text-primary h5">@icon('info') {{ __('components.contract.contract.application.views.amendment._form_without_model.part_informations') }}</legend>

    <input type="hidden" value="{{__('components.contract.contract.application.views.amendment._form_without_model.contract_body')}}" name="contract_part[display_name]">
    <div class="form-group mb-3" id="div-file">
        @form_group([
            'type'        => "file",
            'name'        => "contract_part.file",
            'required'    => false,
            'id'          => 'input-group-file',
            'accept'      => 'application/pdf',
            'text'        => __('components.contract.contract.application.views.amendment._form_without_model.file'),
        ])
    </div>
</fieldset>
@push('scripts')
    <script>
        $(function () {
            /* BEGIN JAVASCRIPT FOR MISSION */
            var setMissionOptions = function(value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.get_enterprise_missions') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        enterprise_id: value
                    },
                    beforeSend: function () {
                        $.each($("select[id='customer-missions']"), function() {
                            $("#" + $(this).attr('id') + " option").remove();
                        })
                    },
                    success: function(response) {
                        $.each(response.data, function(id, label) {
                            $("#customer-missions").append('<option value="'+id+'">'+label+'</option>');
                        });
                        $("#customer-missions").selectpicker("refresh");
                    },
                });
            }

            var setVendorsOptions = function(value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.get_customer_vendors') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        enterprise_id: value
                    },
                    beforeSend: function () {
                        $.each($("select[id='mission-vendors']"), function() {
                            $("#" + $(this).attr('id') + " option").remove();
                        })
                    },
                    success: function(response) {
                        $.each(response.data, function(id, name) {
                            $("#mission-vendors").append('<option value="'+id+'">'+name+'</option>');
                        });
                        $("#mission-vendors").selectpicker("refresh");
                    },
                });
            }

            var value = $('#contract-owner-id').val();
            setMissionOptions(value);
            setVendorsOptions(value);
            /* BEGIN JAVASCRIPT FOR MISSION */
        })
    </script>
@endpush
