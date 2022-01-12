@inject('responseRepository', "App\Repositories\Addworking\Mission\ProposalResponseRepository")
@extends('foundation::layout.app.show')

@section('title', $offer->label)
@section('toolbar')
    @if($offer->status == mission_offer()::STATUS_COMMUNICATED)
        @can('close', $offer)
            <a class="btn btn-outline-primary btn-sm mr-2" href="#" onclick="confirm('{{ __('addworking.mission.offer.show.you_have') }} {{ $numberOfResponses ?? '0' }} {{ __('addworking.mission.offer.show.confirm_close_assignment') }}') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                @icon('check|color:primary|mr:2') {{ __('addworking.mission.offer.show.close_offer') }}
            </a>
            @push('modals')
                <form name="{{ $name }}" action="{{ route('mission.offer.close', $offer) }}" method="POST">
                    @csrf
                </form>
            @endpush
        @endcan
        @cannot('close', $offer)
            <a class="btn btn-outline-primary btn-sm mr-2" href="{{ route('enterprise.offer.request', [$offer->customer, $offer]) }}">
                @icon('envelope|color:primary|mr:3') {{ __('addworking.mission.offer.show.closing_request') }}
            </a>
        @endcannot
    @endif

    @switch(config('app.subdomain'))
        @case('sogetrel')
            @can('broadcast', $offer)
                @if($offer->status == mission_offer()::STATUS_TO_PROVIDE)
                    @button(__('addworking.mission.offer.show.choose_recp_offer')."|href:".route('sogetrel.mission.offer.profile.create', $offer)."|icon:plus|color:outline-success|outline|sm|ml:2|mr:2")
                @endif
            @endcan
        @break

        @case('everial')
            @can('assign', $offer)
                @button(__('addworking.mission.offer.show.assing_mission_directly')."|href:".route($assign , [$offer->customer, $offer])."|icon:check|color:outline-secondary|outline|sm|ml:2")
            @endcan

            @can('broadcast', $offer)
                @if($offer->status == mission_offer()::STATUS_TO_PROVIDE)
                    @button(__('addworking.mission.offer.show.choose_recp_offer')."|href:".route($profile_create ?? 'enterprise.offer.profile.create', [$offer->customer, $offer])."|icon:plus|color:outline-success|outline|sm|ml:2|mr:2")
                @endif
            @endcan
        @break

        @case('edenred')

        @break

        @default
            @can('assign', $offer)
                @button(__('addworking.mission.offer.show.assing_mission_directly')."|href:".route('enterprise.offer.assign.index', [$offer->customer, $offer])."|icon:check|color:outline-secondary|outline|sm|ml:2")
            @endcan
            @can('broadcast', $offer)
                @if($offer->status == mission_offer()::STATUS_TO_PROVIDE)
                    @button(__('addworking.mission.offer.show.choose_recp_offer')."|href:".route($profile_create ?? 'enterprise.offer.profile.create', [$offer->customer, $offer])."|icon:plus|color:outline-success|outline|sm|ml:2|mr:2")
                @endif
            @endcan
    @endswitch
    {{ $offer->views->actions }}
@endsection


@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.offer.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.offer.show.mission_offer').'|href:'.route($index ?? 'mission.offer.index') )
    @breadcrumb_item($offer->label ."|active")
@endsection
@section('tabs')
    <a class="nav-item nav-link {{ session()->get('nav-proposals') ? '' : 'active'}}" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{ __('addworking.mission.offer.show.general_information') }}</a>
    @if($offer->has('files'))
        <a class="nav-item nav-link" id="nav-files-tab" data-toggle="tab" href="#nav-files" role="tab" aria-controls="nav-files" aria-selected="false">{{ __('addworking.mission.offer.show.additional_document') }}</a>
    @endif
    @if($offer->has('proposals'))
        <a class="nav-item nav-link {{ session()->get('nav-proposals') ? 'active' : ''}}" id="nav-proposals-tab" data-toggle="tab" href="#nav-proposals" role="tab" aria-controls="nav-proposals" aria-selected="false">{{ __('addworking.mission.offer.show.mission_proposal') }} ({{ $offer->proposals->count() }})</a>
    @endif
@endsection
@section('content')
    <div class="tab-pane fade {{ session()->get('nav-proposals') ? '' : 'show active'}}" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
        <div class="row">
            @attribute("{$offer->customer->name}|class:col-md-6|icon:user|label:Client")

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "info"])
                @slot('label')
                    {{ __('addworking.mission.offer.show.referent') }}
                @endslot
                {{ optional(optional($offer->referent)->views)->link }}
            @endcomponent

            @section('mission')
            @show

            @attribute("{$offer->label}|class:col-md-6|icon:info|label:".__('addworking.mission.offer.show.assignment_purpose'))

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "info"])
                @slot('label')
                    {{ __('addworking.mission.offer.show.status') }}
                @endslot
                @include('addworking.mission.offer._status')
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-12", 'icon' => "user-tie"])
                @slot('label')
                    {{ __('addworking.mission.offer.show.assignment_desired_skills') }}
                @endslot
                @include('addworking.mission.offer._skills',compact('offer'))
            @endcomponent

            @section('department')
                @component('bootstrap::attribute', ['class' => "col-md-12", 'icon' => "map-marker"])
                    @slot('label')
                        {{ __('addworking.mission.offer.show.location') }}
                    @endslot
                    @include('addworking.mission.mission._departments', ['item' => $offer])
                @endcomponent
            @show

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "calendar-check"])
                @slot('label')
                    {{ __('addworking.mission.offer.show.start_date') }}
                @endslot
                @date($offer->starts_at_desired)
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "calendar-times"])
                @slot('label')
                    {{ __('addworking.mission.offer.show.end_date') }}
                @endslot
                @date($offer->ends_at)
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-12", 'icon' => "info"])
                @slot('label')
                    Description
                @endslot
                {!! $offer->description_html ?: 'n/a' !!}
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "user"])
                @slot('label')
                    {{ __('addworking.mission.offer.show.client_id') }}
                @endslot
                {{ $offer->external_id ?: 'n/a' }}
            @endcomponent

            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "info"])
                @slot('label')
                    {{ __('addworking.mission.offer.show.analytical_code') }}
                @endslot
                {{ $offer->analytic_code }}
            @endcomponent
        </div>
    </div>

    @if($offer->has('files'))
        <div class="tab-pane fade" id="nav-files" role="tabpanel" aria-labelledby="nav-files-tab">
            <div class="row">
                <ul>
                    @forelse($offer->files as $file)
                        <li>
                            <a href="{{ route('file.download', $file) }}">
                                <i class="fa fa-fw fa-download"></i> @lang('messages.download')
                            </a>
                            {{ basename($file->path) }} <small class="text-muted">{{ human_filesize($file->size) }}</small>
                        </li>
                    @empty
                        <p>{{ __('addworking.mission.offer.show.no_document') }}</p>
                    @endforelse
                </ul>
            </div>
        </div>
    @endif

    @if($offer->has('proposals'))
        <div class="tab-pane fade {{ session()->get('nav-proposals') ? 'show active' : ''}}" id="nav-proposals" role="tabpanel" aria-labelledby="nav-proposals-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <colgroup>
                                <col width="25%">
                                <col width="25%">
                                <col width="5%">
                            </colgroup>

                            <thead>
                                @th(__('addworking.mission.offer.show.provider_company').'|not_allowed')
                                @th(__('addworking.mission.offer.show.status').'|not_allowed')
                                @th(__('addworking.mission.offer.show.response_number').'|not_allowed|class:text-center')
                            </thead>

                            <tbody>
                            @forelse($offer->proposals()->cursor() as $proposal)
                                <tr>
                                    <td>
                                        {{ $proposal->vendor->views->link }}
                                    </td>
                                    <td>
                                        @if ($proposal->status == 'interested')
                                            <a href="{{ route('mission.proposal.show', $proposal) }}" data-toggle="tooltip" data-placement="right" title="Cliquez pour voir la proposition">
                                                @include('addworking.mission.proposal._status')
                                            </a>
                                        @else
                                            @include('addworking.mission.proposal._status')
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($responseRepository->countProposalResponsesOf($proposal) == 1)
                                            <a href="{{ route('enterprise.offer.proposal.response.show', [$proposal->offer->customer, $proposal->offer, $proposal, $proposal->responses->first()]) }}">{{  $responseRepository->countProposalResponsesOf($proposal) }}</a>
                                        @elseif ($responseRepository->countProposalResponsesOf($proposal) > 1)
                                            <a href="{{ route('enterprise.offer.response.index', [$proposal->offer->customer, $offer]) }}?filter[vendor]={{ $proposal->vendor->name }}">{{ $responseRepository->countProposalResponsesOf($proposal) }}</a>
                                        @else
                                            0
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        {{ __('addworking.mission.offer.show.no_proposal') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection


@push('scripts')
<script>
    $(function () {
      $('[data-toggle="popover"]').popover()
    })
</script>
@endpush
