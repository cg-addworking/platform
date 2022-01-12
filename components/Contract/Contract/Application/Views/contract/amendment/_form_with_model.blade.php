@inject('enterpriseRepository', 'Components\Contract\Contract\Application\Repositories\EnterpriseRepository')
@inject('contractRepository', "Components\Contract\Contract\Application\Repositories\ContractRepository")

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('components.contract.contract.application.views.contract._form.general_information') }}</legend>

    @if($page === 'create')
        @form_group([
            'text'         => __('components.contract.contract.application.views.contract._form.contract_model'),
            'type'         => "select",
            'name'         => "contract[contract_model]",
            'id'           => "selected_model",
        ])
    @endif

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract._form.name'),
        'type'        => "text",
        'name'        => "contract.name",
        'value'       => __('components.contract.contract.application.views.contract._form.amendment_name_preset', [
                            'count' => $contract_parent->getAmendments()->count()+1,
                            'contract_parent_name' => $contract_parent->getName(),
                        ]),
        'required'    => true,
    ])

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract._form.valid_from'),
        'type'        => "date",
        'name'        => "contract.valid_from",
        'value'       => old('contract.valid_from'),
    ])

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract._form.valid_until'),
        'type'        => "date",
        'name'        => "contract.valid_until",
        'value'       => old('contract.valid_until'),
    ])

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract._form.external_identifier'),
        'type'        => "text",
        'name'        => "contract.external_identifier",
        'value'       => optional($contract_parent)->getExternalIdentifier(),
    ])

    <div id="parties_and_file_container">
        <legend class="text-primary h5">@icon('info') {{ __('components.contract.contract.application.views.amendment._form_without_model.parties_informations') }}</legend>
        @foreach($contractRepository->getSignatoryParties($contract_parent) as $party)
            @form_group([
                'text'        => __('components.contract.contract.application.views.amendment._form_without_model.designation'),
                'type'        => "text",
                'name'        => "contract_party.{$party->getOrder()}.denomination",
                'value'       => $party->getDenomination(),
                'disabled'    => true,
                'required'    => true,
            ])

            @form_group([
                'text'         => __('components.contract.contract.application.views.amendment._form_without_model.enterprise'),
                'type'         => "select",
                'name'         => "contract_party.{$party->getOrder()}.enterprise_id",
                'id'           => "enterprise-party-{$party->getOrder()}",
                'options'      => [$party->getEnterprise()->id => $party->getEnterprise()->name],
                'value'        => $party->getEnterprise()->id,
                'required'     => true,
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

            <input type="hidden" name="contract_party[{{$party->getOrder()}}][order]" value="{{ $party->getOrder() }}">
            <input type="hidden" name="contract_party[{{$party->getOrder()}}][contract_party_id]" value="{{ $party->getId() }}">

        @endforeach

        @include('contract::contract_party._form_validators')

        @include('contract::contract._form_mission')
    </div>
</fieldset>

<input type="hidden" name="contract_parent[enterprise]" id="contract_parent_enterprise" value="{{ $contract_parent->getEnterprise()->id }}">

@push('scripts')
    <script>
        $(function () {
            const mission_id = '{{!is_null($contract_parent->getMission()) ? $contract_parent->getMission()->id : ''}}';

            if (mission_id !== '') {
                $('#select-mission-action option[value="mission_select"]').attr("selected",true);
                $("#div-mission-select").show('slow');
                $("#div-mission-create").hide('slow');
                $('input[name = "contract[mission][label]"]').attr('required', false)
                $('input[name = "contract[mission][starts_at]"]').attr('required', false)
                $('select[name = "contract[mission][vendor_id]"]').attr('required', false)
                $('#customer-missions').prop('disabled', 'disabled');
                $('#div-mission-select').append('<input type="hidden" name="contract[with_mission]" value="true" />');
            } else {
                $('#customer-missions').prop('disabled', false);
            }

            if ($("#select-mission-action").val() === "mission_select" && mission_id !== '') {
                $('#parties_and_file_container').append('<input type="hidden" name="contract[mission][id]" value="'+mission_id+'"/>');
            }

            $("#select-mission-action").change(function() {
                if ($("#select-mission-action").val() === "mission_select" && mission_id !== '') {
                    $('#parties_and_file_container').append('<input type="hidden" name="contract[mission][id]" value="'+mission_id+'"/>');
                } else {
                    $("input[name='contract[mission][id]']").remove();
                }
            });

            var get_contract_model_for_enterprise = function(value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.get_contract_models') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        enterprise_id: value
                    },
                    beforeSend: function () {
                        $('#selected_model option').remove();
                    },
                    success: function(response) {
                        $.each(response.data, function(id, name) {
                            $('#selected_model').append('<option value="'+id+'">'+name+'</option>');
                        });
                    },
                });
            };
            if($('#selected_enterprise').val() != ''){
                get_contract_model_for_enterprise($('#contract_parent_enterprise').val());
            }
            $('#selected_enterprise').on('change', function() {
                get_contract_model_for_enterprise($('#contract_parent_enterprise').val());
            });

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
                            const selected = mission_id === id ? 'selected' : '';

                            $("#customer-missions").append('<option value="'+id+'" '+selected+'>'+label+'</option>');

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

            setMissionOptions($("#contract_parent_enterprise").val());
            setVendorsOptions($("#contract_parent_enterprise").val());
        })
    </script>
@endpush
