<div class="row">
    <div class="col-md-12">
        @form_group([
            'text'         => __('addworking.mission.offer._form.referent'),
            'name'         => "mission_offer.referent_id",
            'type'         => "select",
            'options'      => (auth()->user()->isSupport() ? user()::get() : auth()->user()->enterprise->users)->sortBy('lastname')->pluck('name', 'id'),
            'value'        => $offer->referent->id,
            'required'     => true,
            'selectpicker' => true,
            'search'       => true,
        ])
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @form_group([
            'type'        => "date",
            'name'        => "mission_offer.starts_at_desired",
            'value'       => $offer->starts_at_desired,
            'required'    => true,
            'text'        => __('mission.mission.starts_at_desired'),
            'placeholder' => __('mission.mission.starts_at_placeholder'),
        ])
    </div>
    <div class="col-md-6">
        @form_group([
            'type'        => "date",
            'name'        => "mission_offer.ends_at",
            'value'       => $offer->ends_at,
            'text'        => __('mission.mission.ends_at'),
            'placeholder' => __('mission.mission.ends_at_placeholder'),
        ])
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @form_group([
            'type'        => "textarea",
            'name'        => "mission_offer.description",
            'value'       => $offer->description,
            'required'    => true,
            'text'        => "Description",
            'placeholder' => __('addworking.mission.offer._form.desc_mission_details'),
            'rows'        => 6
        ])
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @form_group([
            'name'        => "mission_offer.external_id",
            'value'       => $offer->external_id,
            'text'        => __('mission.mission.external_id'),
            'placeholder' => "Identifiant externe",
        ])
    </div>
    <div class="col-md-6">
        @unless ($hide_analytic_code ?? false)
            @form_group([
                'name'        => "mission_offer.analytic_code",
                'value'       => $offer->analytic_code,
                'text'        => __('mission.mission.analytic_code'),
                'placeholder' => __('mission.mission.analytic_code_placeholder'),
            ])
        @endunless
    </div>
</div>
