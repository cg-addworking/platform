@component('components.form.group', [
   'name'        => "mission_proposal.external_id",
   'value'       => $proposal->external_id,
   'label'       => __('mission.mission.external_id'),
   'placeholder' => "Identifiant externe",
])
@endcomponent

@component('components.form.group', [
    'type'        => "date",
    'name'        => "mission_proposal.valid_from",
    'value'       => $proposal->valid_from,
    'required'    => true,
    'label'       => __('mission.proposal.valid_from'),
    'placeholder' => __('mission.proposal.valid_from_placeholder'),
])
@endcomponent

@component('components.form.group', [
    'type'        => "date",
    'name'        => "mission_proposal.valid_until",
    'value'       => $proposal->valid_until,
    'required'    => false,
    'label'       => __('mission.proposal.valid_until'),
    'placeholder' => __('mission.proposal.valid_until_placeholder'),
])
@endcomponent

@component('components.form.group', [
    'type'        => "select",
    'name'        => "mission_proposal.need_quotation",
    'value'       => $proposal->need_quotation,
    'values'      => [0 => 'Non', 1 => 'Oui'],
    'required'    => true,
    'label'       => __('mission.proposal.need_quotation.label'),
])
@endcomponent

@component('components.form.group', [
    'type'        => "select",
    'name'        => "mission_proposal.unit",
    'value'       => $proposal->unit,
    'values'      => array_trans(mission_proposal()::getAvailableUnits(), 'mission.mission.unit_'),
    'required'    => false,
    'label'       => __('mission.mission.unit'),
])
@endcomponent

@component('components.form.group', [
    'type'        => "number",
    'step'        => 1,
    'name'        => "mission_proposal.quantity",
    'value'       => $proposal->quantity,
    'required'    => false,
    'label'       => __('mission.mission.quantity'),
])
@endcomponent

@component('components.form.group', [
    'type'        => "number",
    'step'        => .01,
    'name'        => "mission_proposal.unit_price",
    'value'       => $proposal->unit_price,
    'required'    => false,
    'label'       => __('mission.mission.unit_price')
])
@endcomponent

@component('components.form.group', [
    'name'     => "mission_proposal.details",
    'type'     => "textarea",
    'value'    => $proposal->details,
    'required' => false,
    'label'    => __('mission.proposal.details'),
])
@endcomponent
