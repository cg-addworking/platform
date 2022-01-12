@extends('addworking.mission.offer.create', [
    'action'             => route('everial.mission-offer.store'),
    'back'               => 'everial.mission-offer.index',
    'hide_analytic_code' => true,
])

@section('form.customer.id')
    @form_group([
        'text'        => __('everial.mission.offer.create.client'),
        'type'        => "select",
        'name'        => "customer.id",
        'options'     => enterprise('SPF - SOCIETE DE PARTICIPATIONS FINANCIERES')->descendants()->push(enterprise('SPF - SOCIETE DE PARTICIPATIONS FINANCIERES'))->pluck('name', 'id'),
        'required'    => true,
    ])
@endsection

@section('form.label')
    @parent

    @form_group([
        'text'         => __('everial.mission.offer.create.mission'),
        'name'         => "referential.id",
        'type'         => "select",
        'options'      => referential()::get()->pluck('label', 'id'),
        'required'     => true,
        'selectpicker' => true,
        'search'       => true,
    ])

    @form_group([
        'text'         => __('everial.mission.offer.create.bussiness_code'),
        'name'         => "mission_offer.analytic_code",
        'type'         => "select",
        'required'     => true,
        'options'      => referential()::getAvailableAnalyticCodes(),
    ])
@endsection

@section('form.department')
@endsection
