@extends('addworking.mission.offer.edit', [
    'action' => route('everial.mission-offer.update', $offer),
    'method' => "PUT",
    'back' => 'everial.mission-offer.show'
])

@section('form.customer.id')
    @form_group([
        'text'        => __('everial.mission.offer.edit.client'),
        'type'        => "select",
        'name'        => "customer.id",
        'options'     => enterprise('SPF - SOCIETE DE PARTICIPATIONS FINANCIERES')->descendants()->push(enterprise('SPF - SOCIETE DE PARTICIPATIONS FINANCIERES'))->pluck('name', 'id'),
        'required'    => true,
    ])
@endsection

@section('form.label')
    @form_group([
        'type'        => "text",
        'name'        => "mission_offer.label",
        'value'       => $offer->label,
        'required'    => true,
        'text'        => __('everial.mission.offer.edit.purpose'),
        'placeholder' => "Exemple: développement de projet",
    ])

    @form_group([
        'text'        => __('everial.mission.offer.edit.mission'),
        'name'        => "referential.id",
        'type'        => "select",
        'options'     => $offer->getAvailableReferentials(),
        'value'       => optional($offer->everialReferentialMissions->first())->id,
        'required'    => true,
    ])
@endsection

@section('form.department')
@endsection
