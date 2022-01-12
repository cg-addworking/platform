@extends('foundation::layout.app.show')

@section('title', __('addworking.mission.proposal_response.show.offer_answer')." ".$proposal->missionOffer->label)

@section('toolbar')
    <div class="btn-group">
        @can('updateResponseStatus', $response)
            <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="text-center btn btn-outline-primary">
                @icon('plus') {{ __('addworking.mission.proposal_response.show.change_status') }}
            </span>
        @endcan
        <ul class="dropdown-menu dropdown-menu-right">
            @include('addworking.mission.proposal_response._status')
        </ul>
    </div>
    @if(auth()->user()->enterprise->is_customer && $response->status === "final_validation")
        @cannot('close', $offer)
            <a class="text-center btn btn-outline-primary ml-2" href="{{ route('enterprise.offer.request', [$offer->customer, $offer]) }}">
                @icon('envelope|color:primary|mr:2') {{ __('addworking.mission.proposal_response.show.closing_request') }}
            </a>
        @endcannot
        @can('close', $offer)
            <a class="text-center btn btn-outline-primary ml-2" href="#" onclick="confirm('Vous avez {{ $numberOfResponses ?? '0' }} {{ __('addworking.mission.proposal_response.show.close_assignment_confirm') }}') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                @icon('check|color:primary|mr:3') {{ __('addworking.mission.proposal_response.show.close_offer') }}
            </a>

            @push('modals')
                <form name="{{ $name }}" action="{{ route('mission.offer.close', $offer) }}" method="POST">
                    @csrf
                </form>
            @endpush
        @endcan
    @endif
    @can('edit', $response)
        {{ $response->views->actions }}
    @endcan
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.proposal_response.show.dashboard')."|href:".route('dashboard'))
    @if(auth()->user()->enterprise->is_vendor)
        @breadcrumb_item(__('addworking.mission.proposal_response.show.mission_proposal').'|href:'.route('mission.proposal.index') )
        @if(isset($proposal))
            @breadcrumb_item($proposal->label .'|href:'.route('mission.proposal.show', $proposal) )
        @endif
    @else
        @breadcrumb_item(__('addworking.mission.proposal_response.show.mission_offer').'|href:'.route($index_offer ?? 'mission.offer.index') )
        @breadcrumb_item($offer->label .'|href:'.route($show_offer ?? 'mission.offer.show', $offer) )
    @endif
    @breadcrumb_item(__('addworking.mission.proposal_response.show.response').'|href:'.route($index ?? 'enterprise.offer.response.index', [$offer->customer, $offer]) )
    @breadcrumb_item($proposal->missionOffer->label ."|active")
@endsection

@section('tabs')
    <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{ __('addworking.mission.proposal_response.show.general_information') }}</a>
    <a class="nav-item nav-link" id="nav-file-tab" data-toggle="tab" href="#nav-file" role="tab" aria-controls="nav-file" aria-selected="true">{{ __('addworking.mission.proposal_response.show.additional_document') }}</a>
    <a class="nav-item nav-link" id="nav-comment-tab" data-toggle="tab" href="#nav-comment" role="tab" aria-controls="nav-comment" aria-selected="true">{{ __('addworking.mission.proposal_response.show.comment') }}</a>
@endsection

@section('content')
    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
        <div class="row">
            @attribute("{$proposal->missionOffer->label}|class:col-md-6|icon:info|label:".__('addworking.mission.proposal_response.show.mission_offer'))

            @component('bootstrap::attribute', ['icon' => "info", 'class' => "col-md-6"])
                @slot('label')
                    {{ __('addworking.mission.proposal_response.show.status') }}
                @endslot
                {{ __("mission.response.status.{$response->status}") }}
            @endcomponent

            @attribute("{$proposal->missionOffer->customer->name}|class:col-md-6|icon:user|label:".__('addworking.mission.proposal_response.show.client'))

            @component('bootstrap::attribute', ['icon' => "user", 'class' => "col-md-6"])
                @slot('label')
                    {{ __('addworking.mission.proposal_response.show.service_provider') }}
                @endslot
                {{ $proposal->vendor->name }}
            @endcomponent

            @component('bootstrap::attribute', ['icon' => "calendar-check", 'class' => "col-md-6"])
                @slot('label')
                    {{ __('addworking.mission.proposal_response.show.possible_start_date') }}
                @endslot
                @date($response->starts_at)
            @endcomponent

            @component('bootstrap::attribute', ['icon' => "calendar-times", 'class' => "col-md-6"])
                @slot('label')
                    {{ __('addworking.mission.proposal_response.show.possible_end_date') }}
                @endslot
                @date($response->ends_at)
            @endcomponent

            @component('bootstrap::attribute', ['icon' => "calendar-times", 'class' => "col-md-6"])
                @slot('label')
                    {{ __('addworking.mission.proposal_response.show.price') }}
                @endslot
                @money($response->unit_price) @if($response->unit)/ {{ __("mission.mission.{$response->unit}") }} @endif
            @endcomponent

            @component('bootstrap::attribute', ['icon' => "calendar-times", 'class' => "col-md-6"])
                @slot('label')
                    {{ __('addworking.mission.proposal_response.show.amount') }}
                @endslot
                {{$response->quantity}}
            @endcomponent

            @component('bootstrap::attribute', ['icon' => "info", 'class' => "col-md-12"])
                @slot('label')
                    {{ __('addworking.mission.proposal_response.show.description') }}
                @endslot
                {!! $proposal->missionOffer->description_html ?: 'n/a' !!}
            @endcomponent

            @if($response->isFinalValidated())
                @component('bootstrap::attribute', ['icon' => "user", 'class' => "col-md-6"])
                    @slot('label')
                        {{ __('addworking.mission.proposal_response.show.accepted_by') }}
                    @endslot
                    {{ $response->acceptedBy->name }}
                @endcomponent

                @component('bootstrap::attribute', ['icon' => "calendar-check", 'class' => "col-md-6"])
                    @slot('label')
                        {{ __('addworking.mission.proposal_response.show.accept_it') }}
                    @endslot
                    @date($response->accepted_at)
                @endcomponent
            @endif

            @if($response->isRefused())
                @component('bootstrap::attribute', ['icon' => "user", 'class' => "col-md-6"])
                    @slot('label')
                        {{ __('addworking.mission.proposal_response.show.refusal_reason') }}
                    @endslot
                    {{ __("mission.response.reason_for_rejection.{$response->reason_for_rejection}") }}
                @endcomponent

                @component('bootstrap::attribute', ['icon' => "user", 'class' => "col-md-6"])
                    @slot('label')
                        {{ __('addworking.mission.proposal_response.show.refused_by') }}
                    @endslot
                    {{ $response->refusedBy->name }}
                @endcomponent

                @component('bootstrap::attribute', ['icon' => "calendar-times", 'class' => "col-md-6"])
                    @slot('label')
                        {{ __('addworking.mission.proposal_response.show.refused_on') }}
                    @endslot
                    @date($response->refused_at)
                @endcomponent
            @endif
        </div>
    </div>

    <div class="tab-pane fade" id="nav-file" role="tabpanel" aria-labelledby="nav-file-tab">
        <div class="row">
            <ul>
                @forelse($response->files as $file)
                    <li>
                        <a href="{{ route('file.download', $file) }}">
                            <i class="fa fa-fw fa-download"></i> @lang('messages.download')
                        </a>
                        {{ basename($file->path) }} <small class="text-muted">{{ human_filesize($file->size) }}</small>
                    </li>
                @empty
                    <p>{{ __('addworking.mission.proposal_response.show.no_document') }}</p>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="tab-pane fade" id="nav-comment" role="tabpanel" aria-labelledby="nav-comment-tab">
        <div class="row">
            @include('addworking.common.comment._create', ['item' => $response])

            {{ $response->comments }}
        </div>
    </div>
@endsection
