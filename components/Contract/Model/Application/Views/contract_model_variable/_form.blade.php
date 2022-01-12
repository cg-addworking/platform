@inject('contractModelVariableRepository', 'Components\Contract\Model\Application\Repositories\ContractModelVariableRepository')
<fieldset class="mt-5 pt-2">
    @foreach($contract_model->getParties() as $contract_model_party)
        @if(!$contract_model_party->getVariables()->isEmpty())
            <legend class="text-primary h6">@icon('info') {{ $contract_model_party->getDenomination() }}</legend>
            @foreach($contract_model->getParts()->sortBy('created_at') as $contract_model_part)
                @foreach($items as $contract_model_variable)
                    @if($contract_model_variable->getContractModelPart()->getId() === $contract_model_part->getId()
                        && $contract_model_variable->getContractModelParty()->getId() === $contract_model_party->getId())
                        <div class="row">
                            <div class="col-1">
                                @form_group([
                                    'text'        => __('components.contract.model.application.views.contract_model_variable._form.required'),
                                    'type'        => "switch",
                                    'name'        => "contract_model_variable.{$contract_model_variable->getId()}.required",
                                    '_attributes' =>  $contract_model_variable->getRequired() ? ['checked' => 'checked'] : [],
                                ])
                            </div>
                            <div class="col-1">
                                @form_group([
                                    'text'        => __('components.contract.model.application.views.contract_model_variable._form.is_exportable'),
                                    'type'        => "switch",
                                    'name'        => "contract_model_variable.{$contract_model_variable->getId()}.is_exportable",
                                    '_attributes' =>  $contract_model_variable->getIsExportable() ? ['checked' => 'checked'] : [],
                                ])
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>
                                        {{ __('components.contract.model.application.views.contract_model_variable._form.display_name')  }}
                                        <i class="fas fa-info-circle fa-sm text-secondary" tabindex="0" data-toggle="popover" data-trigger="hover" data-content="{{optional($contract_model_variable)->getName()}}"></i>
                                        <sup class=" text-danger  font-italic">*</sup>
                                    </label>
                                    <input type="text" name="contract_model_variable[{{$contract_model_variable->getId()}}][display_name]" value="{{optional($contract_model_variable)->getDisplayName()}}" required="1" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="text-container">
                                    @form_group([
                                        'text'     => __('components.contract.model.application.views.contract_model_variable._form.default_value'),
                                        'type'     => "textarea",
                                        'rows'      => 1,
                                        'name'     => "contract_model_variable.{$contract_model_variable->getId()}.default_value",
                                        'value'    => optional($contract_model_variable)->getDefaultValue(),
                                        'class'    => 'variable_default_value',
                                    ])
                                </div>
                                <div class="option-container">
                                    <label class="control-label" for="option1">{{__('components.contract.model.application.views.contract_model_variable._form.options')}}</label>
                                    <input type="hidden" name="count" value="1" />
                                    <div class="options" data-option-input-name="contract_model_variable[{{$contract_model_variable->getId()}}][options][]">
                                        @if($contract_model_variable->getOptions())
                                            @foreach($contract_model_variable->getOptions() as $option)
                                                <input value="{{$option}}" autocomplete="off" class="input form-control col-10 option option{{$loop->iteration+1}}" style="display: inline; margin-right: 5px;" data-option-number="{{$loop->iteration+1}}" name="contract_model_variable[{{$contract_model_variable->getId()}}][options][]" type="text" maxlength="255" /><button data-option-number="{{$loop->iteration+1}}" class="btn btn-danger remove-me" >-</button>
                                            @endforeach
                                        @endif
                                        <input autocomplete="off" class="input form-control col-10 option option-main" style="display: inline; margin-right: 5px;" data-option-number="1" name="contract_model_variable[{{$contract_model_variable->getId()}}][options][]" type="text" maxlength="255" /><button id="b1" class="btn add-more btn-primary" data-option-number="1" type="button">+</button>
                                    </div>
                                </div>

                            </div>
                            <div class="col-2">
                                @form_group([
                                    'text'         => __('components.contract.model.application.views.contract_model_variable._form.input_type'),
                                    'type'         => "select",
                                    'name'         => "contract_model_variable.{$contract_model_variable->getId()}.input_type",
                                    'value'        => optional($contract_model_variable)->getInputType(),
                                    'options'      => $input_types,
                                    'selectpicker' => true,
                                    'search'       => true,
                                    'class'        => 'variable_input_type',
                                ])
                            </div>
                            <div class="col-2">
                                @form_group([
                                    'text'     => __('components.contract.model.application.views.contract_model_variable._form.description'),
                                    'type'     => "text",
                                    'name'     => "contract_model_variable.{$contract_model_variable->getId()}.description",
                                    'value'    => optional($contract_model_variable)->getDescription(),
                                ])
                            </div>
                            <div class="col-1">
                                <label>{{__('components.contract.model.application.views.contract_model_variable._form.model')}}</label>
                                <b>{{$contract_model_variable->getContractModelPart()->getDisplayName()}}</b>
                            </div>
                            <input type="hidden" name="contract_model_variable[{{$contract_model_variable->getId()}}][id]" value="{{$contract_model_variable->getId()}}">
                        </div>
                    @endif
                @endforeach
            @endforeach
            <hr/>
        @endif
    @endforeach
</fieldset>

@push('scripts')
    <script>
        $(document).ready(function() {
            var handle = function (element) {
                var variable_default_value_input = $(element).parent().parent().find('.variable_default_value');
                var option_container = $(element).parent().parent().find('.option-container');
                var resize = 'none';

                if ($(element).find(':selected').val() == 'long_text') {
                    resize = 'vertical';
                }
                if($(element).find(':selected').val() == 'options') {
                    variable_default_value_input.hide();
                    option_container.show();
                } else {
                    variable_default_value_input.show();
                    option_container.hide();
                }

                variable_default_value_input
                    .css(
                        'resize', resize
                    );
            };

            $(".variable_input_type").change(function() {
                handle($(this));
            });

            $('.variable_input_type').each(function(pos, element) {
                handle(element);
            });

            var bindClickRemoveMe = function () {
                $('.remove-me').on('click',function(e) {
                    e.preventDefault();
                    var optionID = $(this).prev();
                    $(this).remove();
                    optionID.remove();
                });
            }
            var next = 1;
            $(".add-more").click(function(e){
                e.preventDefault();
                var parent_options = $(this).closest('.options');
                var input_name = parent_options.attr("data-option-input-name");
                next++;
                var newIn = '<input autocomplete="off" class="input form-control col-10 option option' + next + '" style="display: inline; margin-right: 5px;" data-option-number="' + next + '" name="'+input_name+'" type="text" maxlength="255">';
                var removeBtn = '<button data-option-number="' + next + '" class="btn btn-danger remove-me" >-</button>';
                $(this).before(removeBtn);
                $(this).before(newIn);
                bindClickRemoveMe();
            });
            bindClickRemoveMe();
        });
    </script>
@endpush