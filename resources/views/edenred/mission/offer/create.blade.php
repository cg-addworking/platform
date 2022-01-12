@extends('addworking.mission.offer.create', [
    'action' => route('edenred.mission-offer.store'),
    'back' => 'edenred.mission-offer.index'
])

@section('form.customer.id')
    @form_group([
        'text'         => __('edenred.mission.offer.create.client'),
        'type'         => "select",
        'name'         => "customer.id",
        'options'      => enterprise('EDENRED')->descendants()->push(enterprise('EDENRED'))->pluck('name', 'id'),
        'required'     => true,
    ])
@endsection

@section('form.label')
    @form_group([
        'text'         => __('edenred.mission.offer.create.assignment_purpose'),
        'name'         => "code.id",
        'type'         => "select",
        'options'      => edenred_code()::get()->pluck('full_label', 'id'),
        'required'     => true,
        'selectpicker' => true,
        'search'       => true,
    ])

    <input type="hidden" name="mission_offer[label]" value="#">
@endsection


@section('form.buttons')
    <button type="submit" name="mission_offer[status]" value="{{ mission_offer()::STATUS_DRAFT }}" class="border btn btn-light"><i class="fa fa-check"></i> @lang('messages.save_draft')</button>
    <button type="submit" name="mission_offer[status]" value="{{ mission_offer()::STATUS_TO_PROVIDE }}" class="btn btn-success"><i class="fa fa-check"></i> @lang('messages.save')</button>
@endsection
