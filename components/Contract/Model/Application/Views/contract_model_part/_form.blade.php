<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('components.contract.model.application.views.contract_model_part._form.general_information') }}</legend>

    <div class="row">
        <div class="col-md-12">
    @form_group([
        'text'        => __('components.contract.model.application.views.contract_model_part._form.display_name'),
        'type'        => "text",
        'name'        => "contract_model_part.display_name",
        'value'       => optional($contract_model_part)->getDisplayName(),
        'required'    => true,
    ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @form_group([
                'text'        => __('components.contract.model.application.views.contract_model_part._form.is_signed'),
                'type'        => "select",
                'name'        => "contract_model_part.is_signed",
                'id'          => "is-signed-select",
                'value'       => optional($contract_model_part)->getIsSigned(),
                'options'     => [
                    0 => __('components.contract.model.application.views.contract_model_part._form.no'),
                    1 => __('components.contract.model.application.views.contract_model_part._form.yes')
                ],
                'required'    => true,
            ])
        </div>
        <div class="col-md-6">
            @form_group([
                'text'        => __('components.contract.model.application.views.contract_model_part._form.is_initialled'),
                'type'        => "select",
                'name'        => "contract_model_part.is_initialled",
                'value'       => optional($contract_model_part)->getIsInitialled(),
                'options'     => [
                0 => __('components.contract.model.application.views.contract_model_part._form.no'),
                1 => __('components.contract.model.application.views.contract_model_part._form.yes')
                ],
                'required'    => true,
            ])
        </div>
    </div>
    <div class="row" id="div-signature">
        <div class="col-md-12">
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="contract_model_part[sign_on_last_page]" value="1" id="is_sign_on_last_page" {{optional($contract_model_part)->getSignOnLastPage() ? 'checked' : ''}} class="form-check-input shadow-sm">
                    <label class="form-check-label">
                        {{__('components.contract.model.application.views.contract_model_part._form.sign_on_last_page')}}
                    </label>
                </div>
            </div>
            <div id="signature_page_input">
                @form_group([
                    'text'        => __('components.contract.model.application.views.contract_model_part._form.signature_page'),
                    'type'        => "number",
                    'name'        => "contract_model_part.signature_page",
                    'min'         => 1,
                    'value'       => optional($contract_model_part)->getSignaturePage(),
                    'required'    => false,
                ])
            </div>
        </div>
    </div>
    @form_group([
        'text'        => __('components.contract.model.application.views.contract_model_part._form.order'),
        'type'        => "number",
        'name'        => "contract_model_part.order",
        'value'       => optional($contract_model_part)->getOrder() ?? $order,
        'required'    => true,
    ])
</fieldset>

@push('scripts')
    <script>
        $(function() {
            if ($('#is_sign_on_last_page').is(':checked')) {
                $( "#signature_page_input" ).hide();
            } else {
                $( "#signature_page_input" ).show();
            }

            if($('#is-signed-select').val() == '0'){
                $("#div-signature").hide();
            } else {
                $("#div-signature").show();
            }

            $("#is-signed-select").change(function() {
                $("#div-signature").toggle("slow");
            });

            $('#is_sign_on_last_page').change(function() {
                $( "#signature_page_input" ).toggle('slow');
            });
        });
    </script>
@endpush
