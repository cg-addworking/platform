<fieldset>
    <div class="row">
        <div class="col-md-6">
            @form_group([
                'type'     => "date",
                'name'     => "response.starts_at",
                'required' => true,
                'text'     => __('offer::response._form.starts_at')
            ])
        </div>
        <div class="col-md-6">
            @form_group([
                'type'     => "date",
                'name'     => "response.ends_at",
                'required' => false,
                'text'     => __('offer::response._form.ends_at')
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @form_group([
                'type'     => "number",
                'step'     => '0.01',
                'name'     => "response.amount_before_taxes",
                'required' => true,
                'text'     => __('offer::response._form.amount_before_taxes')
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @form_group([
                'type'     => "textarea",
                'name'     => "response.argument",
                'required' => true,
                'text'     => __('offer::response._form.argument')
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @form_group([
            'type'        => "file",
            'name'        => "response.file",
            'accept'      => 'application/pdf',
            'text'        => __('offer::response._form.file'),
            'required'    => true,
            ])
        </div>
    </div>
</fieldset>