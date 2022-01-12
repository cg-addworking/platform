@extends('foundation::layout.app.show')

@section('title', __('addworking.mission.proposal.show.mission_proposal'))

@section('toolbar')
    @can('create', [proposal_response(), $proposal])
        @php
            $ready_to_work = $proposal->vendor->isReadyToWorkFor($proposal->offer->customer) && $proposal->vendor->isReadyToWorkFor(enterprise()::addworking());
            $blocker = 'class="d-inline-block" tabindex="0" data-toggle="tooltip"';
            $button = __('addworking.mission.proposal.show.respond_tenders')."|color:outline-success|outline|sm|mr:2|icon:handshake";
        @endphp

        @if ($proposal->offer->status == 'closed')
            <span title="{{ __('addworking.mission.proposal.show.offer_closed') }}" {!! $blocker !!}>
                @button("$button|href:#|disabled|sm")
            </span>
        @elseif (!subdomain('sogetrel') && !$ready_to_work)
            <span title="{{ __('addworking.mission.proposal.show.to_respond_update') }}" {!! $blocker !!}>
                @button("$button|href:#|disabled|sm")
            </span>
        @elseif (subdomain('edenred'))
            @button("$button|href:".route('edenred.enterprise.offer.proposal.response.create', [$proposal->offer->customer, $proposal->offer, $proposal]))
        @else
            @button("$button|href:".route('enterprise.offer.proposal.response.create', [$proposal->offer->customer, $proposal->offer, $proposal]))
        @endif
    @endcan
    @if(subdomain('sogetrel'))
        @can('interestedStatus', $proposal)
            <button class="btn btn-outline-success btn-sm mr-2" data-toggle="modal" data-target="#proposal-interested-{{ $proposal->id }}">
                @icon('file-import|mr:2'){{ __('addworking.mission.proposal.show.information_req') }}
            </button>
            @push('modals')
                @include('addworking.mission.proposal.status._interested')
            @endpush
        @endcan
        @can('storeBpu', $proposal)
            <a class="btn btn-outline-success btn-sm mr-2" href="{{ route('sogetrel.mission.proposal.bpu.create', $proposal)}}">
                @icon('file-download|mr:2'){{ __('addworking.mission.proposal.show.send_bpu') }}
            </a>
        @endcan
    @endif
    {{ $proposal->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.proposal.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.proposal.show.mission_proposal').'|href:'.route('mission.proposal.index') )
    @breadcrumb_item(__('addworking.mission.proposal.show.mission_proposal')."|active")
@endsection

@can('seeSogetrelAlert', $proposal)
    @section('alert', __('addworking.mission.proposal.show.req_sent'))
@endcan

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    @component('bootstrap::attribute', ['icon' => "info", 'class' => "col-md-6"])
                        @slot('label')
                            {{ __('addworking.mission.proposal.show.proposal_status') }}
                        @endslot
                        @include('addworking.mission.proposal._status')
                    @endcomponent
                    @component('bootstrap::attribute', ['icon' => "user", 'class' => "col-md-6"])
                        @slot('label')
                            {{ __('addworking.mission.proposal.show.service_provider') }}
                        @endslot

                        @if($proposal->passwork->exists){{ $proposal->passwork->user->name }}, @endif @if($proposal->vendor->exists) <a href="{{ route('enterprise.show', $proposal->vendor)}}" target="__blank">{{ $proposal->vendor->name }}</a> @endif
                    @endcomponent
                </div>
                <div class="row">
                    @component('bootstrap::attribute', ['icon' => "info", 'class' => "col-md-6"])
                        @slot('label')
                            {{ __('addworking.mission.proposal.show.offer_label') }}
                        @endslot
                        {{ $proposal->offer->label }}
                    @endcomponent
                    @component('bootstrap::attribute', ['icon' => "user", 'class' => "col-md-6"])
                        @slot('label')
                            {{ __('addworking.mission.proposal.show.customer') }} @isset($proposal->external_id)  ({{ $proposal->external_id }}) @endisset
                        @endslot
                         <a href="{{ route('enterprise.show', $proposal->offer->customer)}}" target="__blank">{{ $proposal->offer->customer->name }}</a>
                    @endcomponent
                </div>
                <div class="row">
                    @component('bootstrap::attribute', ['icon' => "calendar-check", 'class' => "col-md-6"])
                        @slot('label')
                            {{ __('addworking.mission.proposal.show.desired_start_date') }}
                        @endslot
                        @date($proposal->offer->starts_at_desired)
                    @endcomponent
                    @component('bootstrap::attribute', ['icon' => "calendar-times", 'class' => "col-md-6"])
                        @slot('label')
                            {{ __('addworking.mission.proposal.show.mission_end') }}
                        @endslot
                        @date($proposal->offer->ends_at)
                    @endcomponent
                </div>
                <div class="row">
                    @component('bootstrap::attribute', ['icon' => "map-marker", 'class' => "col-md-6"])
                        @slot('label')
                            {{ __('addworking.mission.proposal.show.mission_location') }}
                        @endslot
                        @include('addworking.mission.mission._departments', ['item' => $proposal->offer])
                    @endcomponent
                </div>
                <div class="row">
                    @component('bootstrap::attribute', ['icon' => "info", 'class' => "col-md-12"])
                        @slot('label')
                            {{ __('addworking.mission.proposal.show.offer_description') }}
                        @endslot
                        <div class="truncated">
                            {{ $proposal->offer->description }}
                        </div><a href="#" class="readMore">{{ __('addworking.mission.proposal.show.read_more') }}</a>
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div>
            <div class="card shadow">
                <div class="card-header">{{ __('addworking.mission.proposal.show.response_title') }}</div>
                <div class="card-body">
                    <ul>
                        @forelse($proposal->responses as $response)
                            <li><a href="{{ route('enterprise.offer.proposal.response.show', [$proposal->offer->customer, $proposal->offer, $proposal, $response]) }}" target="__blank">
                                {{ __('addworking.mission.proposal.show.response')}} @date($response->created_at)
                            </a> ({{ __("mission.response.status.{$response->status}") }})</li>
                        @empty
                            <span>{{ __('addworking.mission.proposal.show.no_response_sentence') }}</span>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="card-shadow">
                <div class="card-body">
                    @include('addworking.common.comment._create', ['item' => $proposal, 'position' => 'center'])
                    {{ $proposal->comments }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    @if(subdomain('sogetrel'))
        @if($proposal->file)
            <div class="col-md-8 mt-2">
                <div class="card shadow">
                    <button class="btn btn-outline text-left mt-2" type="button" data-toggle="collapse" data-target="#collapse-bpu" aria-expanded="true" aria-controls="collapse-bpu">
                        <h6>@icon('file|color:primary|style:opacity: .4'){{ __('addworking.mission.proposal.show.show_bpu') }} @icon('caret-down')</h6>
                    </button>
                    </label>
                    <div class="collapsed" id="collapse-bpu">
                        <div class="ml-3">
                            <a href="{{ route('file.download', $proposal->file) }}"><i class="fa fa-fw fa-download"></i> {{ basename($proposal->file->path) }} <small class="text-muted">{{ human_filesize($proposal->file->size) }}</small></a>
                        </div>
                        <div>
                            {{ $proposal->file->views->iframe(['ratio' => "4by3"]) }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    <div class="col-md-8 mt-2">
        <div class="card shadow">
            <div class="card-header">@icon('file-archive|color:primary|style:opacity: .4'){{ __('addworking.mission.proposal.show.files_title') }}</div>
                <div class="card-body">
                    <ul style="list-style-type: none;" class="ml-0 pl-0">
                        @forelse($proposal->offer->files as $offerFile)
                            <li class="ml-0 pl-0"><button class="btn btn-outline text-left mt-2" type="button" data-toggle="collapse" data-target="#collapse-files-{{ $id = uniqid()}}" aria-expanded="false" aria-controls="collapse-files-{{ $id }}">
                                <span>@icon('file|color:primary|style:opacity: .4'){{ basename($offerFile->path) }} @icon('caret-down')</span>
                            </button></li>
                            <div class="collapse" id="collapse-files-{{ $id }}">
                                <div class="ml-3">
                                    <a href="{{ route('file.download', $offerFile) }}"><i class="fa fa-fw fa-download"></i> {{ __('addworking.mission.proposal.show.download') }}<small class="text-muted">{{ human_filesize($offerFile->size) }}</small></a>
                                </div>
                                <div>
                                    {{ $offerFile->views->iframe(['ratio' => "4by3"]) }}
                                </div>
                            </div>
                        @empty
                            <span>{{ __('addworking.mission.proposal.show.no_file_sentence') }}</span>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
        var charLimit = 300;

    function truncate(el) {
        var text = el.html();
        el.attr("data-originalText", text);
        el.html(text.substring(0, charLimit) + "...");
    }

    function reveal(el) {
        el.html(el.attr("data-originalText"));
    }

    $(".truncated").each(function() {
        truncate($(this));
    });

    $("a.readMore").on("click", function(e) {
        e.preventDefault();
        if ($(this).text() === "Voir plus") {
            $(this).text("Masquer");
            reveal($(this).prev());
        } else {
            $(this).text("Voir plus");
            truncate($(this).prev());
        }
    });
</script>
@endpush