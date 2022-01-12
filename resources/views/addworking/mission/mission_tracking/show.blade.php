@extends('foundation::layout.app.show')

@section('title', $mission->number." - ".$mission->label)

@section('toolbar')
    @button(__('addworking.mission.mission_tracking.show.return')."|href:".route('mission.tracking.index')."|icon:arrow-left|color:secondary|outline|sm|ml:2")
    {{ $tracking->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.mission_tracking.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item($mission->label .'|href:'.route('mission.show', $mission) )
    @breadcrumb_item(__('addworking.mission.mission_tracking.show.mission_followup').'|href:'.route('mission.tracking.index') )
    @breadcrumb_item(__('addworking.mission.mission_tracking.show.mission_monitoring')."|active")
@endsection

@section('tabs')
    <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{ __('addworking.mission.mission_tracking.show.general_information') }}</a>
    <a class="nav-item nav-link" id="nav-files-tab" data-toggle="tab" href="#nav-files" role="tab" aria-controls="nav-files" aria-selected="true">{{ __('addworking.mission.mission_tracking.show.attachement') }}</a>
@endsection

@section('content')
    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
        @component('bootstrap::attribute', ['icon' => "calendar", 'class' => "col-md-12"])
            @slot('label')
                {{ __('addworking.mission.mission_tracking.show.period_concerned') }}
            @endslot
            {{ $tracking->milestone->label ?? 'n/a' }}
        @endcomponent
        @component('bootstrap::attribute', ['icon' => "info", 'class' => "col-md-12"])
            @slot('label')
                {{ __('addworking.mission.mission_tracking.show.description') }}
            @endslot
            {{ $tracking->description_html }}
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "info", 'class' => "col-md-12"])
            @slot('label')
                {{ __('addworking.mission.mission_tracking.show.external_identifier') }}
            @endslot
            {{ $tracking->external_id }}
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "info", 'class' => "col-md-12"])
            @slot('label')
                {{ __('addworking.mission.mission_tracking.show.tracking_lines') }}
            @endslot

            <div class="alert alert-primary alert-dismissible fade show mt-3" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <p class="mb-0">
                    {{ __('addworking.mission.mission_tracking.show.information_note') }} :<br>
                    <li>{{ __('addworking.mission.mission_tracking.show.mission_monitoring_statement') }}</li>
                    <li>{{ __('addworking.mission.mission_tracking.show.mission_followup_text') }}</li>
                    <li>{{ __('addworking.mission.mission_tracking.show.commenting_text') }}</li>
                </p>
            </div>

            <div class="text-right mb-2">
                @button(__('addworking.mission.mission_tracking.show.add_row')."|href:".route('mission.tracking.line.create', [$mission, $tracking])."|icon:plus|color:outline-success")
            </div>
            <div class="table-responsive" style="padding: 2px">
                <table class="table table-hover">
                    <colgroup>
                        <col width="20%">
                        <col width="5%">
                        <col width="10%">
                        <col width="8%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="17%">
                        <col width="10%">
                    </colgroup>

                    <thead>
                        <th>{{ __('addworking.mission.mission_tracking.show.label') }}</th>
                        <th>{{ __('addworking.mission.mission_tracking.show.accounting_expense') }}</th>
                        <th>{{ __('addworking.mission.mission_tracking.show.unit_price') }}</th>
                        <th>{{ __('addworking.mission.mission_tracking.show.amount') }}</th>
                        <th>{{ __('addworking.mission.mission_tracking.show.amount_before_taxes') }}</th>
                        <th>{{ __('addworking.mission.mission_tracking.show.customer_status') }}</th>
                        <th>{{ __('addworking.mission.mission_tracking.show.provider_status') }}</th>
                        <th>{{ __('addworking.mission.mission_tracking.show.refusal_reason') }}</th>
                        <th class="text-right">{{ __('addworking.mission.mission_tracking.show.actions') }}</th>
                    </thead>
                    <tbody>
                        @foreach($trackingLines as $line)
                            <tr>
                                <td>{{ $line->label }}</td>
                                <td>
                                    {{ optional($line->accountingExpense()->first())->getDisplayName() ?? 'n/a' }}
                                </td>
                                <td>{{ $line->unit_price }} / @lang("mission.mission.{$line->unit}")</td>
                                <td>{{ $line->quantity }}</td>
                                <td>@money($line->amount)</td>
                                <td>@include('addworking.mission.mission_tracking_line._status', ['status' => $line->validation_customer])</td>
                                <td>@include('addworking.mission.mission_tracking_line._status', ['status' => $line->validation_vendor])</td>
                                <td>{{ $line->reason_for_rejection ? $line->reason_for_rejection : 'n/a' }}</td>
                                <td class="text-right">
                                    @if(auth()->user()->isSupport())
                                        {{ $line->views->actions }}
                                    @else
                                         <div class="row float-right pr-1">
                                            @can('edit', $line)
                                                <a href="{{route('mission.tracking.line.edit', [$mission, $tracking, $line])}}" class="mt-1 mr-2">
                                                    <i class="fas fa-edit fa-1x"></i>
                                                </a>
                                            @endcan
                                            @if(auth()->user()->enterprise->is_customer)
                                                <form method="POST" action="{{ route('mission.tracking.line.validation', [$mission, $tracking, $line]) }}">
                                                    @csrf
                                                    <input type="hidden" name="line[validation_customer]" value="{{ mission_tracking_line()::STATUS_VALIDATED }}">
                                                    <button type="submit" class="btn btn-outline-success btn-sm"
                                                    @if ($line->isAnsweredByCustomer())
                                                        disabled data-toggle="tooltip" data-placement="top" title="{{ __('addworking.mission.mission_tracking.show.express_agreement') }}"
                                                    @endif>@icon('check')</button>
                                                </form>

                                                <button class="btn btn-outline-danger btn-sm ml-2" data-toggle="modal" data-target="#reject-line-customer-{{ $line->id }}"
                                                    @if ($line->isAnsweredByCustomer())
                                                        disabled data-toggle="tooltip" data-placement="top" title="{{ __('addworking.mission.mission_tracking.show.express_agreement') }}"
                                                    @endif>
                                                    @icon('times')
                                                </button>
                                                @push('modals')
                                                    @include('addworking.mission.mission_tracking_line._reject', [
                                                        'mission_tracking_line' => $line,
                                                        'is_vendor' => false
                                                    ])
                                                @endpush
                                            @endif

                                            @if(auth()->user()->enterprise->is_vendor)
                                                <form method="POST" action="{{ route('mission.tracking.line.validation', [$mission, $tracking, $line]) }}">
                                                    @csrf
                                                    <input type="hidden" name="line[validation_vendor]" value="{{ mission_tracking_line()::STATUS_VALIDATED }}">
                                                    <button type="submit" class="btn btn-outline-success btn-sm"
                                                    @if ($line->isAnsweredByVendor())
                                                        disabled data-toggle="tooltip" data-placement="top" title="Vous avez déjà exprimé votre accord (ou non)"
                                                    @endif>@icon('check')</button>
                                                </form>

                                                <button class="btn btn-outline-danger btn-sm ml-2" data-toggle="modal" data-target="#reject-line-vendor-{{ $line->id }}"
                                                    @if ($line->isAnsweredByVendor())
                                                        disabled data-toggle="tooltip" data-placement="top" title="Vous avez déjà exprimé votre accord (ou non)"
                                                    @endif>
                                                    @icon('times')
                                                </button>
                                                @push('modals')
                                                    @include('addworking.mission.mission_tracking_line._reject', [
                                                        'mission_tracking_line' => $line,
                                                        'is_vendor' => true
                                                    ])
                                                @endpush
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endcomponent

        @component('bootstrap::attribute', ['icon' => "comments", 'class' => "col-md-12"])
            @slot('label')
                {{ __('addworking.mission.mission_tracking.show.comments') }}
            @endslot
            <div class="row">
                @include('addworking.common.comment._create', ['item' => $tracking])

                {{ $tracking->comments }}
            </div>
        @endcomponent
    </div>
    <div class="tab-pane fade show" id="nav-files" role="tabpanel" aria-labelledby="nav-files-tab">
        @if($tracking->hasAttachments())
            @if($tracking->attachments()->count() === 1)
                {{ $tracking->attachments()->first()->views->iframe }}
            @else
                <div class="row">
                    <ul>
                        @foreach($tracking->attachments()->get() as $file)
                            <li>
                                <a href="{{ route('file.download', $file) }}">
                                    <i class="fa fa-fw fa-download"></i> @lang('messages.download')
                                </a>
                                {{ basename($file->path) }} <small class="text-muted">{{ human_filesize($file->size) }}</small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif
    </div>
@endsection
