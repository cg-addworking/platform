@if ($average_daily_rate->exists)
    <input type="hidden" name="average_daily_rate[id]" value="{{ $average_daily_rate->id }}">
@endif

<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') {{ __('edenred.common.average_daily_rate._form.general_information') }}</legend>

    @form_group([
        'text'        => __('edenred.common.average_daily_rate._form.service_provider'),
        'type'        => "select",
        'name'        => "vendor.id",
        'value'       => optional($average_daily_rate)->vendor->id,
        'options'     => optional($average_daily_rate)->getAvailableVendors(),
        'required'    => true,
    ])

    @form_group([
        'text'        => __('edenred.common.average_daily_rate._form.rate'),
        'type'        => "number",
        'step'        => .01,
        'name'        => "average_daily_rate.rate",
        'value'       => optional($average_daily_rate)->rate,
        'required'    => true,
    ])
</fieldset>
