<div class="offset-3 col-lg-6">
    @form_group([
        'text'        => __('components.contract.contract.application.views.contract_part._form.is_from_annexes_options'),
        'type'        => "select",
        'name'        => "contract_part.is_from_annexes",
        'id'          => "is_from_annexes-select",
        'options'     => [
        0 => __('components.contract.contract.application.views.contract_part._form.upload_file'),
        1 => __('components.contract.contract.application.views.contract_part._form.is_from_annexes')
        ],
        'required'    => true,
    ])

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract_part._form.annex'),
        'type'        => "select",
        'name'        => "contract_part.annex_id",
        'id'          => "annex-select",
        'required'    => false,
    ])

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract_part._form.display_name'),
        'type'        => "text",
        'name'        => "contract_part.display_name",
        'id'          => "annex-display-name-input",
        'required'    => true,
    ])

    @form_group([
        'text'        => __('components.contract.contract.application.views.contract_part._form.is_signed'),
        'type'        => "select",
        'name'        => "contract_part.is_signed",
        'id'          => "is-signed-select",
        'options'     => [
            0 => __('components.contract.contract.application.views.contract_part._form.no'),
            1 => __('components.contract.contract.application.views.contract_part._form.yes')
        ],
        'required'    => true,
    ])

    <div id="div-signature">
        @form_group([
            'text'        => __('components.contract.contract.application.views.contract_part._form.signature_mention'),
            'type'        => "text",
            'name'        => "contract_part.signature_mention",
            'required'    => false,
        ])

        @form_group([
            'text'        => __('components.contract.contract.application.views.contract_part._form.signature_page'),
            'type'        => "number",
            'name'        => "contract_part.signature_page",
            'required'    => false,
        ])

    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" name="contract_part[sign_on_last_page]" value="1" id="is_sign_on_last_page" checked class="form-check-input shadow-sm">
            <label class="form-check-label">
                {{__('components.contract.contract.application.views.contract_part._form.sign_on_last_page')}}
            </label>
        </div>
    </div>
</div>

<div class="form-group mb-3" id="div-file">
    @form_group([
        'type'        => "file",
        'name'        => "contract_part.file",
        'required'    => true,
        'id'          => 'input-group-file',
        'accept'      => 'application/pdf',
        'text'        => __('components.contract.contract.application.views.contract_part._form.file'),
    ])
</div>
@push('scripts')
    <script>
        $(document).ready(function(){
            if($('#is-signed-select').val() === '0'){
                $("#div-signature").hide();
            } else {
                $("#div-signature").show();
            }

            $("#is-signed-select").change(function() {
                $("#div-signature").toggle("slow");
            });

            function loadAnnexName() {
                if ($('#is_from_annexes-select').val() === '1') {
                    var annex_name = $('#annex-select option:selected').text();
                    $('#annex-display-name-input').val(annex_name);
                }
            }
            $('#annex-select').change(function () {
                loadAnnexName();
            });
            loadAnnexName();

            function displayOrHideAnnexes() {
                if ($('#is_from_annexes-select').val() === '0') {
                    $('#annex-select').parent('.form-group').hide();
                    $('#div-file').show();
                    $('#input-group-file').attr('required', true);
                    $('#is-signed-select').parent('.form-group').show();
                } else {
                    $('#annex-select').parent('.form-group').show();
                    $('#div-file').hide();
                    $('#input-group-file').attr('required', false);
                    $('#is-signed-select').parent('.form-group').hide();
                    loadAnnexName();
                }
            }

            $('#is_from_annexes-select').on('change', function() {
                displayOrHideAnnexes();
            });
            displayOrHideAnnexes();

            function loadAnnexes() {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "{{ route('contract.part.ajax_get_available_annexes', $contract) }}",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend: function () {
                        $("#annex-select option").remove();
                    },
                    success: function(response) {
                        $.each(response.data, function(id, name) {
                            $('#annex-select').append('<option value="'+id+'">'+name+'</option>');
                        });
                        loadAnnexName();
                    },
                });
            }
            loadAnnexes();
        });
    </script>
@endpush