<div class="form-group">
    <label id="">
        {{__('components.contract.contract.application.views.contract._form.mission')}}
    </label>
    <select class="custom-select" id="select-mission-action" required>
        <option value="mission_none">{{ __('components.contract.contract.application.views.contract._form.mission_none') }}</option>
        <option value="mission_select">{{ __('components.contract.contract.application.views.contract._form.mission_select') }}</option>
        <option value="mission_create">{{ __('components.contract.contract.application.views.contract._form.mission_create') }}</option>
    </select>
</div>

<div class="form-group mb-3" id="div-mission-select">
    @form_group([
        'text'         => __('components.contract.contract.application.views.contract._form.mission_select'),
        'type'         => "select",
        'name'         => "contract.mission.id",
        'selectpicker' => true,
        'search'       => true,
        'id'           => 'customer-missions'
    ])
</div>

<div class="form-group" id="div-mission-create">
    <fieldset class="mt-5 pt-2">
        <legend class="text-primary h6">@icon('handshake') {{ __('components.contract.contract.application.views.contract._form.mission_create') }}</legend>

        @form_group([
            'type'     => "text",
            'name'     => "contract.mission.label",
            'text'     => __('addworking.mission.mission._form.assignment_purpose'),
            'help'     => __('addworking.mission.mission._form.project_development_help'),
            'required' => true,
        ])

        <div class="row">
            <div class="col-md-6">
                @form_group([
                    'type'     => "date",
                    'name'     => "contract.mission.starts_at",
                    'text'     => __('mission.mission.starts_at'),
                    'required' => true,
                ])
            </div>
            <div class="col-md-6">
                @form_group([
                    'type' => "date",
                    'name' => "contract.mission.ends_at",
                    'text' => __('mission.mission.ends_at'),
                ])
            </div>
        </div>

        @form_group([
            'type'     => "select",
            'name'     => "contract.mission.vendor_id",
            'required' => true,
            'text'     => __('mission.mission.vendor'),
            'id'       => 'mission-vendors'
        ])
    </fieldset>
</div>

@push('scripts')
    <script>
        missionAction();

        $("#select-mission-action").change(function() {
            missionAction();
        });

        $('#contract-owner-id').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
        });

        function missionAction() {
            if ($("#select-mission-action").val() === "mission_select") {
                $("#div-mission-select").show('slow');
                $("#div-mission-create").hide('slow');
                $('input[name = "contract[mission][label]"]').attr('required', false)
                $('input[name = "contract[mission][starts_at]"]').attr('required', false)
                $('select[name = "contract[mission][vendor_id]"]').attr('required', false)
                $('#div-mission-select').append('<input type="hidden" name="contract[with_mission]" value="true" />');
            }

            if ($('#select-mission-action').val() === "mission_create") {
                $("#div-mission-create").show('slow');
                $('input[name = "contract[mission][label]"]').attr('required', true)
                $('input[name = "contract[mission][starts_at]"]').attr('required', true)
                $('select[name = "contract[mission][vendor_id]"]').attr('required', true)
                $("#div-mission-select").hide('slow');
                $('#div-mission-create').append('<input type="hidden" name="contract[with_mission]" value="true" />');
            }

            if ($('#select-mission-action').val() === "mission_none") {
                $("#div-mission-select").hide();
                $("#div-mission-create").hide();
                $('input[name = "contract[mission][label]"]').attr('required', false)
                $('input[name = "contract[mission][starts_at]"]').attr('required', false)
                $('select[name = "contract[mission][vendor_id]"]').attr('required', false)
                $('#div-mission-create').append('<input type="hidden" name="contract[with_mission]" value="false" />');
            }
        }

        $('form').submit(function () {
            if ($("#div-mission-select").is(":hidden")) {
                $("#div-mission-select").remove();
            }
            if ($("#div-mission-create").is(":hidden")) {
                $("#div-mission-create").remove();
            }
        });
    </script>
@endpush
