@inject('contractVariableRepository', 'Components\Contract\Contract\Application\Repositories\ContractVariableRepository')
@inject('contractPartRepository', 'Components\Contract\Contract\Application\Repositories\ContractPartRepository')
<fieldset class="mt-3 pt-2">
    <ul class="nav nav-tabs nav-justified">
        @foreach($variables_by_parts as $part_id => $contract_model_part)
            <li class="nav-item">
                <a class="nav-link @if ($loop->first) active @endif" id="nav-{{str_slug($part_id)}}-tab" data-toggle="tab" href="#nav-{{str_slug($part_id)}}" role="tab" aria-controls="nav-{{str_slug($part_id)}}" aria-selected="true"><h5><b>{{strtoupper($contractPartRepository->find($part_id)->getDisplayName())}}</b></h5></a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content mt-3 col-md-8 offset-md-2">
        @foreach($variables_by_parts as $part_id => $contract_variables)
            <div class="tab-pane fade @if ($loop->first) show active @endif" id="nav-{{str_slug($part_id)}}" role="tabpanel" aria-labelledby="nav-{{str_slug($part_id)}}-tab">
                    @foreach($contract_variables as $contract_variable)
                        <div class="{{ in_array($contract_variable->getId(), $requested_contract_variables) ? 'alert alert-primary' : '' }}">
                            <div class="row">
                                <div class="col">
                                    <p><span style="font-size:16px;font-weight: bold; ">{{optional($contract_variable->getContractModelVariable())->getDisplayName()}} </span>
                                        ({{$contract_variable->getContractParty()->getDenomination()}})
                                        @if($contract_variable->getContractModelVariable()->getDescription()) {{'('.$contract_variable->getContractModelVariable()->getDescription().')'}}@endif
                                    </p>
                                </div>
                            </div>
                            <div class="row" style="margin-top:-25px">
                                <div class="col-md-10">
                                    @switch(true)
                                        @case($contractVariableRepository->isOptions($contract_variable))
                                            @form_group([
                                                'type'     => "select",
                                                'name'     => "contract_variable.{$contract_variable->getId()}",
                                                'value'    => $contract_variable->getValue(),
                                                'options'  => array_mirror($contract_variable->getContractModelVariable()->getOptions()),
                                                'disabled' => $contractVariableRepository->isEditable($contract_variable) ? false: true,
                                                'class'    => 'input-contract-variable',
                                                'id'       => $contract_variable->getId(),
                                            ])
                                        @break
                                        @case($contractVariableRepository->isLongText($contract_variable))
                                            @form_group([
                                                'type'     => "textarea",
                                                'name'     => "contract_variable.{$contract_variable->getId()}",
                                                'value'    => $contract_variable->getValue(),
                                                'disabled' => $contractVariableRepository->isEditable($contract_variable) ? false: true,
                                                'class'    => 'input-contract-variable',
                                                'id'       => $contract_variable->getId(),
                                                'rows'     => 8,
                                            ])
                                        @break
                                        @case($contractVariableRepository->isDate($contract_variable))
                                        @case($contractVariableRepository->isDatetime($contract_variable))
                                            @form_group([
                                                'type'     => 'date',
                                                'name'     => "contract_variable.{$contract_variable->getId()}",
                                                'value'    => $contract_variable->getValue(),
                                                'disabled' => $contractVariableRepository->isEditable($contract_variable) ? false: true,
                                                'class'    => 'input-contract-variable',
                                                'id'       => $contract_variable->getId(),
                                            ])
                                        @break
                                        @default
                                            @form_group([
                                                'type'     => "text",
                                                'name'     => "contract_variable.{$contract_variable->getId()}",
                                                'value'    => $contract_variable->getValue(),
                                                'disabled' => $contractVariableRepository->isEditable($contract_variable) ? false: true,
                                                'class'    => 'input-contract-variable',
                                                'id'       => $contract_variable->getId(),
                                            ])
                                    @endswitch
                                </div>
                                <div class="col-md-1">
                                    @if($contractVariableRepository->isEditable($contract_variable))
                                        <a class="btn mt-4 btn-sm btn-outline-success btn-update-variable" href="#"><i class="fa fa-check"></i></a>
                                    @endif
                                </div>
                                <div class="col-md-1">
                                    <br>
                                    <input type="checkbox" class="request-value-checkbox align-middle" data-variable-id="{{$contract_variable->getId()}}">
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
        @endforeach
    </div>
</fieldset>

<br>
<br>
<div id="request-variable-value-sucess" class="alert alert-success offset-md-2 col-md-7" style="display: none">
    <p>{{__('components.contract.contract.application.views.contract_variable.define_value.success_send_request_contract_variable_value')}}</p>
</div>

<div id="request-variable-value-form-container" class="row offset-md-2">
    <div class="col-md-4">
        <div class="form-group">
            <label>{{__('components.contract.contract.application.views.contract_variable.define_value.request_contract_variable_value_user_to_request')}}</label>
            <select data-live-search="1" class="form-control shadow-sm selectpicker col-md-8 ml-1" id="request-variable-value-user-id">
                @foreach($contract_users as $id => $name)
                    <option value="{{$id}}">{{$name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <br>
        <a role="button" href="#" id="request-value-btn" class="btn btn-outline-primary col-md-6 mt-2">
            <i class="fas fa-fw fa-envelope"></i>
            {{__('components.contract.contract.application.views.contract_variable.define_value.send_request_contract_variable_value')}}
        </a>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('.btn-update-variable').hide();

        $('.input-contract-variable').change(function () {
            $(this).parent().parent().find('.btn-update-variable').show();
        });
        $('.btn-update-variable').on('click', function (e) {
            e.preventDefault();
            $(this).hide();
            var input_contract_variable = $($(this).parent().parent().find('.input-contract-variable')[2]);
            var value = input_contract_variable.val();
            var id = input_contract_variable.attr('id');

            $.ajax({
                type: "PUT",
                dataType: "json",
                url: "{{ route('contract.variable.update_value', $contract) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    variable_value: value, 
                    variable_id: id, 
                },
            });
        });

        $('.request-value-checkbox').hide();
        $('.request-value-checkbox').prop('checked', false);
        $('#request-variable-value-form-container').hide();

        const hideShowSendRequestForm = function () {
            if ($('.request-value-checkbox:checked').length <= 0) {
                $('#request-variable-value-form-container').hide();
            } else {
                $('#request-variable-value-form-container').show();
            }
        }
        hideShowSendRequestForm();

        $('#request-variable-value-display-button').click(function () {
            $('.request-value-checkbox').show();
        });

        var request_value_base_url = '{{ domain_route(route('contract.variable.define_value', $contract), $contract->getEnterprise()) }}';
        var request_value_url = '';
        $('.request-value-checkbox').change(function () {
            hideShowSendRequestForm()

            request_value_url = request_value_base_url+'?requested-contract-variables=';
            $('.request-value-checkbox').each(function (e, el) {
                if ((request_value_url + $(el).attr('data-variable-id') + ',').length >= 2000) {
                    alert("{{__('components.contract.contract.application.views.contract_variable.define_value.url_is_too_long')}}");
                    $('#request-variable-value-form-container').hide();
                    return false;
                } else {
                    if ($(el).is(':checked')) {
                        request_value_url = request_value_url + $(el).attr('data-variable-id') + ',';
                    }
                }
            });
            request_value_url = request_value_url.slice(0, -1);
        });

        $('#request-value-btn').click(function (e) {
            e.preventDefault();
            var user_id = $('#request-variable-value-user-id').val();
            $.ajax({
                type: "POST",
                url: "{{ route('contract.request_contract_variable_value', $contract) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    user_id: user_id,
                    url: request_value_url
                },
                success: function (response) {
                    $('#request-variable-value-sucess').show();
                },
            });
        });

        if ($('div.tab-pane > div.alert.alert-primary').length) {
            var requested_variable_input_container = $('div.tab-pane > div.alert.alert-primary')[0];
            var pannel_id                          = $(requested_variable_input_container).parent().attr('id');
            $('#'+pannel_id+'-tab').click();
        }
    });
</script>
@endpush