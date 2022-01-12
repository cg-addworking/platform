@inject('contractRepository', 'Components\Contract\Contract\Application\Repositories\ContractRepository')

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('components.contract.contract.application.views.contract._form.general_information') }}</legend>

    @if($page === 'create')
        <div class="form-group">
            <label>
                {{__('components.contract.contract.application.views.contract._form.enterprise')}}
                <sup class=" text-danger font-italic">*</sup>
            </label>
            <select data-live-search="1" class="form-control shadow-sm selectpicker" id="selected_enterprise" name="contract[enterprise_model]">
                @foreach($enterprises_with_model as $enterprise)
                    <option value="{{$enterprise->id}}">{{$enterprise->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>
                {{__('components.contract.contract.application.views.contract._form.contract_model')}}
                <sup class=" text-danger font-italic">*</sup>
            </label>
            <select data-live-search="1" class="form-control shadow-sm selectpicker" id="selected_model" name="contract[contract_model]">
                @foreach($contract_models as $contract_model_id => $contract_model_name)
                    <option value="{{$contract_model_id}}">{{$contract_model_name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>
                {{__('components.contract.contract.application.views.contract._form.enterprise_owner')}}
                <sup class=" text-danger font-italic">*</sup>
            </label>
            <select data-live-search="1" class="form-control shadow-sm selectpicker" id="contract-owner-id" name="contract[enterprise]">
                @foreach($enterprises as $enterprise_owner_id => $enterprise_owner_name)
                    <option
                            value="{{ $enterprise_owner_id }}"
                            @if(! is_null($mission) && $mission->customer->id == $enterprise_owner_id)
                                selected
                            @endif
                    >
                        {{ $enterprise_owner_name }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    @form_group([
        'text'     => __('components.contract.contract.application.views.contract._form.name'),
        'type'     => "text",
        'name'     => "contract.name",
        'value'    => optional($contract)->getName() ?? $suggested_name,
        'required' => true,
    ])

    @if(!$contractRepository->hasYousignProcedureId($contract))
        <div class="row">
            <div class="col-md-6">
                @form_group([
                    'text'  => __('components.contract.contract.application.views.contract._form.valid_from'),
                    'type'  => "date",
                    'name'  => "contract.valid_from",
                    'value' => optional($contract)->getValidFrom() ?? (isset($mission) ? $mission->starts_at : ''),
                ])
            </div>
            <div class="col-md-6">
                @form_group([
                    'text'  => __('components.contract.contract.application.views.contract._form.valid_until'),
                    'type'  => "date",
                    'name'  => "contract.valid_until",
                    'value' => optional($contract)->getvalidUntil() ?? (isset($mission) ? $mission->ends_at : ''),
                ])
            </div>
        </div>
    @endif

    @can('editExternalIdentifier', $contract)
        @form_group([
            'text'     => __('components.contract.contract.application.views.contract._form.external_identifier'),
            'type'     => "text",
            'name'     => "contract.external_identifier",
            'value'    => optional($contract)->getExternalIdentifier(),
            'required' => false,
        ])
    @endcan
</fieldset>

@if($page === 'create')
    @push('scripts')
        <script>
            var preselected_enterprise_owner_id = '{{ ! is_null($mission) ? $mission->customer->id : ''}}';
            var load_enterprise_owner = function(value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('contract.get_enterprises') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        contract_model_id: value
                    },
                    beforeSend: function () {
                        $('#contract-owner-id option').remove();
                    },
                    success: function(response) {
                        $.each(response.data, function(id, name) {
                            var selected = (preselected_enterprise_owner_id !== '' && id == preselected_enterprise_owner_id)? 'selected' : '';
                            $('#contract-owner-id').append('<option value="'+id+'" '+selected+'>'+name+'</option>');
                            $("#contract-owner-id").selectpicker("refresh");
                        });
                    },
                });
            }
            $('#selected_model, #selected_enterprise').on('change', function() {
                load_enterprise_owner($('#selected_model').val());
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
                        $('#selected_model').append('<option value="">{{ __('components.contract.contract.application.views.contract._form.no_selection') }}</option>');
                        $.each(response.data, function(id, name) {
                            $('#selected_model').append('<option value="'+id+'">'+name+'</option>');
                            $("#selected_model").selectpicker("refresh");
                        });
                        load_enterprise_owner($('#selected_model').val());
                    },
                });
            };
            if($('#selected_enterprise').val() != ''){
                get_contract_model_for_enterprise($('#selected_enterprise').val());
            }
            $('#selected_enterprise').on('change', function() {
                get_contract_model_for_enterprise($(this).val());
            });

            @if($mission)
                var customer_id = "{{$mission->getCustomer()->id}}";
                $('#selected_enterprise option[value="'+customer_id+'"]').prop('selected', true);
                $("#selected_enterprise").selectpicker("refresh");
                $('#contract-owner-id option[value="'+customer_id+'"]').prop('selected', true);
                $("#contract-owner-id").selectpicker("refresh");
                get_contract_model_for_enterprise($('#selected_enterprise').val());
            @endif
        </script>
    @endpush
@endif
