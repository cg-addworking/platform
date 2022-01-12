<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('components.sogetrel.mission.application.views.mission_tracking_line_attachment._form.title') }}</legend>

    <div class="row mb-4">
        <div class="col-md-3">
            @form_group([
                'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.create.amount'),
                'type' => "number",
                'name' => "mission_tracking_line_attachment.amount",
                'value' => $mission_tracking_line_attachment->amount,
                'min' => 0,
                'step' => 0.01,
                'required' => true,
            ])
        </div>
        <div class="col-md-3">
            @form_group([
                'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.create.signed_at'),
                'type' => "date",
                'name' => "mission_tracking_line_attachment.signed_at",
                'value' => $mission_tracking_line_attachment->signed_at,
                'max' => date('Y-m-d'),
                'required' => true,
            ])
        </div>
        <div class="col-md-3">
            @form_group([
                'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.create.submitted_at'),
                'type' => "date",
                'name' => "mission_tracking_line_attachment.submitted_at",
                'value' => $mission_tracking_line_attachment->submitted_at,
                'max' => date('Y-m-d'),
            ])
        </div>
        <div class="col-md-3">
            <div class="fomr-group">
                <label>Options</label>

                @form_control([
                    'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.create.reverse_charges'),
                    'type' => "switch",
                    'name' => "mission_tracking_line_attachment.reverse_charges",
                    'value' => 1,
                    'checked' => (bool) $mission_tracking_line_attachment->reverse_charges,
                    'class' => "mb-2",
                ])

                @form_control([
                    'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.create.direct_billing'),
                    'type' => "switch",
                    'name' => "mission_tracking_line_attachment.direct_billing",
                    'checked' => (bool) ($mission_tracking_line_attachment->direct_billing ?? true),
                    'value' => 1,
                    'class' => "mb-2",
                ])
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            @form_group([
                'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.create.num_attachment'),
                'name' => "mission_tracking_line_attachment.num_attachment",
                'value' => $mission_tracking_line_attachment->num_attachment,
            ])
        </div>
        <div class="col-md-3">
            @form_group([
                'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.create.num_order'),
                'name' => "mission_tracking_line_attachment.num_order",
                'value' => $mission_tracking_line_attachment->num_order,
            ])
        </div>
        <div class="col-md-3">
            @form_group([
                'text' => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.create.num_site'),
                'name' => "mission_tracking_line_attachment.num_site",
                'value' => $mission_tracking_line_attachment->num_site,
            ])
        </div>
        @unless($mission_tracking_line_attachment->exists)
            <div class="col-md-3">
                @form_group([
                    'text'   => __('components.sogetrel.mission.application.views.mission_tracking_line_attachment.create.file'),
                    'accept' => 'application/pdf',
                    'type'   => "file",
                    'name'   => "file",
                ])
            </div>
        @endunless
    </div>
</fieldset>
