<fieldset class="mt-5 pt-2">
    @foreach($contract->getContractModel()->getParties()->sortBy('order') as $contract_model_party)
        <legend class="text-primary h6">@icon('handshake') {{ __('components.contract.contract.application.views.contract_party._form.party') }} : {{$contract_model_party->getDenomination()}}</legend>

        <div class="form-group">
            <label>
                {{__('offer::offer.construction._form.enterprises')}}
                <sup class=" text-danger font-italic">*</sup>
            </label>
            <select id="party-contract-no-{{$loop->iteration}}" data-live-search="1" class="form-control selectpicker" name="contract_party[{{$loop->iteration}}][enterprise_id]" required="required">
                <option></option>
            </select>
        </div>

        @form_group([
            'text'         => __('components.contract.contract.application.views.contract_party._form.signatory'),
            'type'         => "select",
            'name'         => "contract_party.{$loop->iteration}.signatory_id",
            'required'     => true,
            'id'           => "enterprise-signatory-{$loop->iteration}",
        ])

        @form_group([
            'text'        => __('components.contract.contract.application.views.contract_party._form.order'),
            'type'        => "text",
            'name'        => "contract_party.{$loop->iteration}.order",
            'value'       => $contract_model_party->getOrder(),
            'required'    => true,
        ])

        <input type="hidden" name="contract_party[{{$loop->iteration}}][denomination]" value="{{ $contract_model_party->getDenomination() }}">
        <input type="hidden" name="contract_party[{{$loop->iteration}}][contract_model_party_id]" value="{{ $contract_model_party->getId() }}">
    @endforeach

    @include('contract::contract_party._form_validators')

    @includeWhen(is_null($contract->getMission()), 'contract::contract._form_mission')
    <input type="hidden" name="contract[enterprise]" id="contract-owner-id" value="{{ $contract->getEnterprise()->getId() }}">
</fieldset>

@push('scripts')
    <script>
        $(function () {
            $('.selectpicker').selectpicker('refresh');

            @if($contract->getMission())
                function addMissionParties(vendor_id, customer_id) {
                    if ($('#party-contract-no-1 option[value="'+vendor_id+'"]').length === 0) {
                        var vendor_name = '{{ $contract->getMission()->getVendor()->name }}';
                        $("#party-contract-no-1").append('<option value="' + vendor_id + '" selected>' + vendor_name + '</option>');
                        $("#party-contract-no-1").selectpicker("refresh");
                    }

                    if ($('#party-contract-no-2 option[value="'+customer_id+'"]').length === 0) {
                        var customer_name = '{{ $contract->getMission()->getCustomer()->name }}';
                        $("#party-contract-no-2").append('<option value="' + customer_id + '" selected>' + customer_name + '</option>');
                        $("#party-contract-no-2").selectpicker("refresh");
                    }
                }

                var vendor_id = '{{ $contract->getMission()->getVendor()->id }}';
                var customer_id = '{{ $contract->getMission()->getCustomer()->id }}';
                loadParties(1, vendor_id);
                loadParties(2, customer_id);
                addMissionParties(vendor_id, customer_id);
            @else
                get_parties_of_contract();
            @endif

            function get_parties_of_contract() {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.party.get_parties_of_contract', $contract) }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        $.each(response.data, function (id, name) {
                            $("select[id^='party-contract-no-']").append('<option value="' + id + '">' + name + '</option>');
                        });

                        $("select[id^='party-contract-no-']").selectpicker("refresh");
                    },
                });
            }

            function loadParties(part, value) {
                var signatories_select = "enterprise-signatory-" + part;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.get_signatories') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
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
            };

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

            if ($("#contract-owner-id").val() !== null) {
                setMissionOptions($("#contract-owner-id").val());
                setVendorsOptions($("#contract-owner-id").val());
            }

            $("#contract-owner-id").change(function () {
                var value = $(this).val();
                setMissionOptions(value);
                setVendorsOptions(value);
            });

            $("select[id^='party-contract-no-']").on("change", function(e) {
                e.preventDefault();
                const part = $(this).attr('id').split('-')[3];
                const enterprise_id = $(this).val();
                loadParties(part, enterprise_id);
            })

            $('select#party-contract-no-2').on('change', function() {
                var id = $('select#party-contract-no-2 :selected').val();
                $('select#mission-vendors option[value="'+id+'"]').prop('selected', true);
                $('select#mission-vendors').selectpicker("refresh");
            });
        })
    </script>
@endpush
