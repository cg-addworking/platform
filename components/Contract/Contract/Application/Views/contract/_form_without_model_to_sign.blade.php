<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('components.contract.contract.application.views.contract._form_without_model_to_sign.contract_informations') }}</legend>

        <div class="form-group">
            <label>
                {{__('components.contract.contract.application.views.contract._form_without_model_to_sign.owner')}}
                <sup class=" text-danger font-italic">*</sup>
            </label>
            <select data-live-search="1" class="form-control shadow-sm selectpicker" id="contract-owner-id" name="contract[enterprise]" required>
                <option></option>
                @foreach($enterprises as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        @form_group([
            'text'        => __('components.contract.contract.application.views.contract._form_without_model_to_sign.name'),
            'type'        => "text",
            'name'        => "contract.name",
            'required'    => true,
        ])

    <div class="row">
        <div class="col-md-6">
            @form_group([
                'text'        => __('components.contract.contract.application.views.contract._form_without_model_to_sign.valid_from'),
                'type'        => "date",
                'name'        => "contract.valid_from",
            ])
        </div>
        <div class="col-md-6">
            @form_group([
                'text'        => __('components.contract.contract.application.views.contract._form_without_model_to_sign.valid_until'),
                'type'        => "date",
                'name'        => "contract.valid_until",
            ])
        </div>

    </div>

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract._form_without_model_to_sign.external_identifier'),
        'type'        => "text",
        'name'        => "contract.external_identifier",
    ])

    <legend class="text-primary h5">@icon('info') {{ __('components.contract.contract.application.views.contract._form_without_model_to_sign.parties_informations') }}</legend>

        @for($i = 1; $i <= 2; $i++)
            @form_group([
                'text'        => __('components.contract.contract.application.views.contract._form_without_model_to_sign.designation'),
                'type'        => "text",
                'name'        => "contract_party.{$i}.denomination",
                'value'       => __('components.contract.contract.application.views.contract._form_without_model_to_sign.party_'.$i.'_designation'),
                'required'    => true
            ])

            <div class="row">
                <div class="col-md-6">
                    @form_group([
                        'text'         => __('components.contract.contract.application.views.contract._form_without_model_to_sign.enterprise'),
                        'type'         => "select",
                        'name'         => "contract_party.{$i}.enterprise_id",
                        'id'           => "enterprise-party-{$i}",
                        'required'     => true,
                    ])
                </div>

                <div class="col-md-6">
                    @form_group([
                        'text'         => __('components.contract.contract.application.views.contract._form_without_model_to_sign.signatory'),
                        'type'         => "select",
                        'name'         => "contract_party.{$i}.signatory_id",
                        'required'     => true,
                        'id'           => "enterprise-signatory-{$i}",
                    ])
                </div>
            </div>

            <input type="hidden" name="contract_party[{{$i}}][order]" value="{{$i}}">

            <hr>
        @endfor

</fieldset>

@include('contract::contract._form_mission')

<fieldset>
    <legend class="text-primary h5">@icon('info') {{ __('components.contract.contract.application.views.contract._form_without_model_to_sign.part_informations') }}</legend>

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract._form_without_model_to_sign.contract_label'),
        'type'        => "text",
        'name'        => "contract_part.display_name",
        'required'    => true,
    ])

    <div class="row">
        <div class="col-md-6">
            @form_group([
                'text'        => __('components.contract.model.application.views.contract_model_part._form.signature_mention'),
                'type'        => "text",
                'name'        => "contract_part.signature_mention",
                'required'    => true,
            ])
        </div>
        <div class="col-md-6">
            @form_group([
                'text'        => __('components.contract.model.application.views.contract_model_part._form.signature_page'),
                'type'        => "number",
                'name'        => "contract_part.signature_page",
                'required'    => true,
            ])
        </div>
    </div>

    <div class="form-group mb-3" id="div-file">
        @form_group([
        'type'        => "file",
        'name'        => "contract_part.file",
        'id'          => 'input-group-file',
        'accept'      => 'application/pdf',
        'text'        => __('components.contract.contract.application.views.contract._form_without_model_to_sign.file'),
        'required'    => true,
        ])
    </div>
</fieldset>
@push('scripts')
    <script>
        $(function () {
            var setPartyTwoOptions = function(value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.get_vendors') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        enterprise_id: value
                    },
                    beforeSend: function () {
                        $.each($("select[id='enterprise-party-2']"), function() {
                            $("#" + $(this).attr('id') + " option").remove();
                        })
                    },
                    success: function(response) {
                        $.each($("select[id='enterprise-party-2']"), function() {
                            var attribute = $(this).attr('id');
                            $.each(response.data, function(id, name) {
                                $("#" + attribute).append('<option value="'+id+'">'+name+'</option>');
                            });
                            load_signatories($("select[id='enterprise-party-2']").val(), "enterprise-signatory-2");
                        });
                    },
                });
            }
            $("select[id='enterprise-party-1']").change(function () {
                var value = $(this).val();
                setPartyTwoOptions(value);
            });

            var load_signatories = function(value, signatories_select) {
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

            var setPartyOneOptions = function(value){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.get_partners') }}",
                    data: {
                        enterprise_id: value,
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend: function () {
                        $.each($("select[id='enterprise-party-1']"), function() {
                            $("#" + $(this).attr('id') + " option").remove();
                        });
                    },
                    success: function(response) {
                        $.each(response.data, function(id, name) {
                            $("select#enterprise-party-1").append('<option value="'+id+'">'+name+'</option>');
                        });
                        if($("select[id='enterprise-party-1']").val() != null){
                            load_signatories($("select[id='enterprise-party-1']").val(), "enterprise-signatory-1");
                            setPartyTwoOptions($("select[id='enterprise-party-1']").val());
                        }
                    },
                });
            };
            $("select[id='contract-owner-id']").change(function () {
                var value = $(this).val();
                setPartyOneOptions(value);
            });
            setPartyOneOptions($('#contract-owner-id').val());

            $("select[id^='enterprise-party-']").change(function () {
                var part = $(this).attr('id').split('-')[2];
                var value = $(this).val();
                var signatories_select = "enterprise-signatory-" + part;
                load_signatories(value, signatories_select);
            });

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
            setMissionOptions($("#contract-owner-id").val());

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

            setVendorsOptions($('#contract-owner-id').val());
            $("select[id='contract-owner-id']").change(function () {
                var value = $(this).val();
                setMissionOptions(value);
                setVendorsOptions(value);
            });

            $("select[id='enterprise-party-2']").change(function () {
                var value = $(this).val();
                $('#mission-vendors option:selected').prop("selected", false);
                $('#mission-vendors option[value="'+value+'"]').prop("selected", true);
                $("#mission-vendors").selectpicker("refresh");
            });
            /* BEGIN JAVASCRIPT FOR MISSION */
        })
    </script>
@endpush
