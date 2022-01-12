@inject('contractRepository', 'Components\Contract\Contract\Application\Repositories\ContractRepository')
@extends('foundation::layout.app.show')

@section('title', $mission->label)

@section('toolbar')
    @can('linkMissionToContract', $mission)
        <div class="dropdown">
            <button class="btn btn-outline-success btn-sm dropdown-toggle mr-2" type="button" id="{{ $id = uniqid('button-') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @icon('plus') {{ __('addworking.mission.mission.show.contractualize') }}
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $id }}">
                @if(auth()->user()->isSupport())
                    <a class="dropdown-item" href={{route('support.contract.create',['mission' =>$mission->id])}}> {{__('addworking.mission.mission.show.create_contract')}}</a>
                @else
                    @can('create',get_class($contractRepository->make()))
                        <a class="dropdown-item" href={{route('contract.create',['mission' =>$mission->id])}}> {{__('addworking.mission.mission.show.create_contract')}}</a>
                    @endcan
                @endif
                    <a class="dropdown-item" href={{route('contract_mission.create',['mission' =>$mission->id])}}> {{__('addworking.mission.mission.show.link_contract')}}</a>
            </div>
        </div>
    @endcan

    <a class="text-center text-primary btn btn-outline-primary btn-sm mr-2" title="Changer le statut" data-toggle="modal" data-target="#change-status-{{ $mission->id }}">
        <i class="fa fa-edit"></i> {{ __('addworking.mission.mission.show.change_status') }}
    </a>
    {{ $mission->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.mission.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item('Missions|href:'.route('mission.index') )
    @breadcrumb_item($mission->label ."|active")
@endsection

@section('tabs')
    <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{ __('addworking.mission.mission.show.general_information') }}</a>
    @if(auth()->user()->isSupport())
        <a class="nav-item nav-link" id="nav-invoice-tab" data-toggle="tab" href="#nav-invoice" role="tab" aria-controls="nav-invoice" aria-selected="false">{{ __('addworking.mission.mission.show.billing') }}</a>
    @endif
    <a class="nav-item nav-link" id="nav-more-tab" data-toggle="tab" href="#nav-more" role="tab" aria-controls="nav-more" aria-selected="false">{{ __('addworking.mission.mission.show.further_information') }}</a>
@endsection

@section('content')
    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
        <div class="row">
            @if(auth()->user()->isSupport())
                @attribute(($mission->number ?? 'n/a').'|class:col-md-6|icon:hashtag|label:'.__('addworking.mission.mission.show.number'))
                @attribute(($mission->id ?? 'n/a').'|class:col-md-6|icon:key|label:'.__('addworking.mission.mission.show.id'))
            @endif

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "user", 'label' =>__('addworking.mission.mission.show.customer')])
                {{ $mission->customer->views->link }}
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "user", 'label' => __('addworking.mission.mission.show.assigned_provider')])
                {{ $mission->vendor->views->link }}
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "info"])
                @slot('label')
                    {{ __('addworking.mission.mission.show.status') }}
                @endslot
                @include('addworking.mission.mission._status')
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "map-marker"])
                @slot('label')
                    {{ __('addworking.mission.mission.show.location') }}
                @endslot
                @if($mission->proposal->exists)
                    {{ $mission->proposal->missionOffer->departments->pluck('name')->implode(' | ') }}
                @else
                    {{ $mission->location }}
                @endif
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "calendar-check"])
                @slot('label')
                    {{ __('addworking.mission.mission.show.start_date') }}
                @endslot
                @date($mission->starts_at)
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "info"])
                @slot('label')
                    {{ __('addworking.mission.mission.show.end_date') }}
                @endslot
                @date($mission->ends_at)
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "info"])
                @slot('label')
                    {{ __('addworking.mission.mission.show.price') }}
                @endslot
                @money($mission->amount)
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "info"])
                @slot('label')
                    {{ __('addworking.mission.mission.show.amount') }}
                @endslot
                {{ $mission->quantity && $mission->unit ? $mission->quantity." x ".__("mission.mission.{$mission->unit}") : 'n/a' }}
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-12", 'icon' => "hourglass-end"])
                @slot('label')
                    {{ __('addworking.mission.mission.show.tracking_mode') }}
                @endslot
                @if ($mission->milestone_type)
                    {{ __("mission.milestone.type.{$mission->milestone_type}") }}
                @else
                    <a href="{{ route('mission.create_milestone_type', $mission) }}"> {{ __('addworking.mission.mission.show.determine') }} </a>
                @endif
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-12", 'icon' => "info"])
                @slot('label')
                    {{ __('addworking.mission.mission.show.tracking_mode') }}
                @endslot
                @if($mission->proposal->exists)
                    {!! $mission->proposal->missionOffer->description_html !!}
                @else
                    <p>{!! $mission->description_html ?: 'n/a' !!}</p>
                @endif
            @endcomponent

            @if($mission->proposal->exists)
                @component('bootstrap::attribute', ['class' => "col-md-12", 'icon' => "info"])
                    @slot('label')
                        {{ __('addworking.mission.mission.show.description') }}
                    @endslot
                    <a href="{{ route('mission.proposal.show', $mission->proposal) }}">{{ __('addworking.mission.mission.show.consult_proposal') }}</a>
                @endcomponent
            @endif
        </div>
    </div>

    @if(auth()->user()->isSupport())
        <div class="tab-pane fade" id="nav-invoice" role="tabpanel" aria-labelledby="nav-invoice-tab">
            <div class="row">
                @component('bootstrap::attribute', ['class' => "col-md-12", 'icon' => "info"])
                    @slot('label')
                        {{ __('addworking.mission.mission.show.incoming_invoice') }}
                    @endslot

                    {{ $mission->inboundInvoiceItem->exists ? $mission->inboundInvoiceItem->views->link : 'n/a' }}
                @endcomponent
            </div>
        </div>
    @endif

    <div class="tab-pane fade" id="nav-more" role="tabpanel" aria-labelledby="nav-more-tab">
        <div class="row">
            @attribute("{$mission->number}|class:col-md-6|icon:hashtag|label:Numéro")
            @if ($mission->external_id)
                @attribute("{$mission->external_id}|class:col-md-6|icon:hashtag|label:Identifiant externe")
            @endif

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "user"])
                @slot('label')
                    {{ __('addworking.mission.mission.show.created_by') }}
                @endslot
                {{--user($mission->created_by)->name--}}
            @endcomponent

            @attribute("{$mission->created_at}|class:col-md-6|icon:info|label:".__('addworking.mission.mission.show.creation_date'))
            @attribute("{$mission->updated_at}|class:col-md-12|icon:info|label:".__('addworking.mission.mission.show.last_update'))

            @if ($mission->closed_by)
                @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "user"])
                    @slot('label')
                        {{ __('addworking.mission.mission.show.closed_by') }}
                    @endslot
                    {{ user($mission->closed_by)->name }}
                @endcomponent
                @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "info"])
                    @slot('label')
                        {{ __('addworking.mission.mission.show.closing_date') }}
                    @endslot
                    {{ $mission->closed_at }}
                @endcomponent
            @endif

            @if ($mission->abandoned_by)
                @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "user"])
                    @slot('label')
                        {{ __('addworking.mission.mission.show.abondend_by') }}
                    @endslot
                    {{ user($mission->abandoned_by)->name }}
                @endcomponent

                @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "info"])
                    @slot('label')
                        {{ __('addworking.mission.mission.show.abondend_date') }}
                    @endslot
                    {{ $mission->abandoned_at }}
                @endcomponent
            @endif
        </div>
    </div>
@endsection
