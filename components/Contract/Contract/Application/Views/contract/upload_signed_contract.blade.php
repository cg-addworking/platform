@extends('foundation::layout.app.create', ['action' => route('contract.save_upload_signed_contract', $contract), 'enctype' => "multipart/form-data"])

@section('title', __('components.contract.contract.application.views.contract.upload_signed_contract.title'))

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract.upload_signed_contract.return')."|href:".route('contract.show', $contract)."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('contract::contract._breadcrumb', ['page' => "upload_signed_contract"])
@endsection

@section('form')
    @form_group([
        'text'        => __('components.contract.contract.application.views.contract.upload_signed_contract.display_name'),
        'type'        => "text",
        'name'        => "contract_part.display_name",
        'required'    => true,
    ])

    <div class="form-group mb-3" id="div-file">
        @form_group([
            'type'        => "file",
            'name'        => "contract_part.file",
            'required'    => false,
            'id'          => 'input-group-file',
            'accept'      => 'application/pdf',
            'text'        => __('components.contract.contract.application.views.contract.upload_signed_contract.file'),
        ])
    </div>

    @if(!$parties->isEmpty())
        @foreach($parties as $party)
            @form_group([
                'text'        => __(
                    'components.contract.contract.application.views.contract.upload_signed_contract.party_signed_at',
                    [ 'party_name' => $party->getSignatory()->firstname. ' ' . $party->getSignatory()->lastname . ' ('.$party->getDenomination().')']
                ),
                'type'        => 'date',
                'name'        => 'contract_party.signed_at.'.$party->getId(),
                'required'    => true,
            ])
        @endforeach
    @endif

    @button(__('components.contract.contract.application.views.contract.upload_signed_contract.submit')."|type:submit|color:success|shadow|icon:check")
@endsection