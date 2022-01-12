@inject('familyEnterpriseRepository', 'App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository')
@inject('enterpriseRepository', 'App\Repositories\Addworking\Enterprise\EnterpriseRepository')

@extends('layouts.app')

@section('id', 'sogetrel-user-passwork-show')

@section('title')
    @component('components.panel')
        <h1 class="m-0">Passwork {{ $passwork->user->name }}</h1>

        <div class="mt-3">
            @if(auth()->user()->enterprise->is_customer || auth()->user()->isSupport())
                <a href="{{ route('sogetrel.passwork.index') }}">
                    <i class="fa fa-arrow-left"></i>
                    <span>{{ __('sogetrel.user.passwork.show.return') }}</span>
                </a> |
            @else
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-arrow-left"></i>
                    <span>{{ __('sogetrel.user.passwork.show.return') }}</span>
                </a> |
            @endif
            @if(sogetrel_passwork()::STATUS_BLACKLISTED == $passwork->status
                && !(auth()->user()->enterprise->is_customer || auth()->user()->isSupport()))
                <span class="text-danger">
                    <i class="fa fa-times"></i> {{ __('sogetrel.user.passwork.show.reject') }}
                </span>
            @else
                <b>{{ __('sogetrel.user.passwork.show.status') }}: </b> @include('sogetrel.user.passwork._status') |
            @endif
            <b>{{ __('sogetrel.user.passwork.show.created_at') }}: </b> @date($passwork->created_at)
        </div>
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            @include('_form_errors')
            @component('components.panel', ['icon' => "black-tie"])
                @slot('heading')
                    Passwork
                @endslot
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#_general_informations" aria-controls="_general_informations" role="tab" data-toggle="tab">{{ __('sogetrel.user.passwork.show.general_information') }}</a>
                    </li>
                    <li role="presentation">
                        <a href="#_electrician_technician" aria-controls="_electrician_technician" role="tab" data-toggle="tab">{{ __('sogetrel.user.passwork.show.electrician_technician') }}</a>
                    </li>
                    <li role="presentation">
                        <a href="#_office_studies" aria-controls="_office_studies" role="tab" data-toggle="tab">{{  __('sogetrel.user.passwork.show.design_office') }}</a>
                    </li>
                    <li role="presentation">
                        <a href="#_civil_engineering" aria-controls="_civil_engineering" role="tab" data-toggle="tab">{{ __('sogetrel.user.passwork.show.civil_engineering') }}</a>
                    </li>
                    <li role="presentation">
                        <a href="#_certifications" aria-controls="_certifications" role="tab" data-toggle="tab">{{ __('sogetrel.user.passwork.show.certifications') }}</a>
                    </li>
                    @if(auth()->user()->enterprise->is_customer || auth()->user()->isSupport())
                        <li role="presentation">
                            <a href="#_operational_monitoring" aria-controls="_operational_monitoring" role="tab" data-toggle="tab">{{ __('sogetrel.user.passwork.show.operational_monitoring') }}</a>
                        </li>
                    @endif
                    <li role="presentation">
                        <a href="#_files" aria-controls="_files" role="tab" data-toggle="tab">{{ __('sogetrel.user.passwork.show.files') }}</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="{{ !isset($active)? 'tab-pane active' : 'tab-pane' }}" id="_general_informations">
                        <h3>{{ __('sogetrel.user.passwork.show.general_information') }}</h3>
                        @include('sogetrel.user.passwork.tabs._general_informations', ['passwork' => $passwork])
                    </div>
                    <div role="tabpanel" class="tab-pane" id="_electrician_technician">
                        <h3>{{ __('sogetrel.user.passwork.show.electrician_technician') }}</h3>
                        @include('sogetrel.user.passwork.tabs._electrician_technician', ['passwork' => $passwork])
                    </div>
                    <div role="tabpanel" class="tab-pane" id="_office_studies">
                        <h3>{{ __('sogetrel.user.passwork.show.design_office') }}</h3>
                        @include('sogetrel.user.passwork.tabs._office_studies', ['passwork' => $passwork])
                    </div>
                    <div role="tabpanel" class="tab-pane" id="_civil_engineering">
                        <h3>{{ __('sogetrel.user.passwork.show.civil_engineering') }}</h3>
                        @include('sogetrel.user.passwork.tabs._civil_engineering', ['passwork' => $passwork])
                    </div>
                    <div role="tabpanel" class="tab-pane" id="_certifications">
                        <h3>{{ __('sogetrel.user.passwork.show.certifications') }}</h3>
                        @include('sogetrel.user.passwork.tabs._certifications', ['passwork' => $passwork])
                    </div>
                    @if(auth()->user()->enterprise->is_customer || auth()->user()->isSupport())
                        <div role="tabpanel" class="tab-pane" id="_operational_monitoring">
                            <h3>{{ __('sogetrel.user.passwork.show.operational_monitoring') }}</h3>
                            @include('sogetrel.user.passwork.tabs._operational_monitoring', ['passwork' => $passwork])
                        </div>
                    @endif
                    <div role="tabpanel" class="tab-pane" id="_files">
                        <h3>{{ __('sogetrel.user.passwork.show.files') }}</h3>
                        @include('sogetrel.user.passwork.tabs._files', ['passwork' => $passwork])
                    </div>
                </div>
            @endcomponent
        </div>
        @can('attachToErymaOrSubsidiaries', $passwork)
            <div class="col-md-3">
                @component('components.panel', ['icon' => "check-square-o"])
                    @slot('heading')
                        {{ __('sogetrel.user.passwork.show.actions') }}
                    @endslot
                    @if($passwork->user->enterprise->isVendorOf(auth()->user()->enterprise))
                    <a class="btn btn-block btn-success attach" href="#" disabled>
                        <i class="mr-2 fa fa-plus"></i> {{ __('sogetrel.user.passwork.show.attach') }}
                    </a>
                    <div class="alert alert-success mt-2" role="alert">
                        Ce passwork est déjà référencé.
                    </div>
                    @else
                        <a class="btn btn-block btn-success attach" href="{{ route('sogetrel.passwork.attach', $passwork) }}">
                            <i class="mr-2 fa fa-plus"></i> {{ __('sogetrel.user.passwork.show.attach') }}
                        </a>
                    @endif
                @endcomponent
            </div>
        @else
            @if((auth()->user()->enterprise->is_customer && !$familyEnterpriseRepository->getDescendants($enterpriseRepository->fromName('ERYMA'), true)
                ->contains(auth()->user()->enterprise)) || auth()->user()->isSupport())
                @can('status', $passwork)
                    <div class="col-md-3">
                    @component('components.panel', ['icon' => "check-square-o"])
                        @slot('heading')
                            {{ __('sogetrel.user.passwork.show.actions') }}
                        @endslot
                        <p>
                            <a class="btn btn-block btn-success" href="{{route('sogetrel.passwork.acceptation.create', $passwork)}}" style="text-align: left">
                                <i class="mr-2 fa fa-check"></i> {{ __('sogetrel.user.passwork.show.accept') }}
                            </a>
                        </p>
                        @include('sogetrel.user.passwork.modals._accepted_passwork')
                        <p>
                            <button class="btn btn-block btn-success" data-toggle="modal" data-target="#passwork-accepted-queued-modal" style="text-align: left">
                                <i class="mr-2 fa fa-check"></i> {{ __('sogetrel.user.passwork.show.accept_queue') }}
                            </button>
                        </p>
                        @include('sogetrel.user.passwork.modals._accepted_passwork_queued')

                        <p>
                            <button class="btn btn-block btn-danger" data-toggle="modal" data-target="#passwork-refused-modal" style="text-align: left">
                                <i class="mr-2 fa fa-times"></i> {{ __('sogetrel.user.passwork.show.refuse') }}
                            </button>
                        </p>
                        @include('sogetrel.user.passwork.modals._refused_passwork')

                        <button class="btn btn-block btn-default mt-2" data-toggle="modal" data-target="#passwork-qualified-modal" style="text-align: left">
                            <i class="mr-2 fa fa-clock-o"></i> {{ __('sogetrel.user.passwork.show.prequalified') }}
                        </button>
                        @include('sogetrel.user.passwork.modals._qualified_passwork')

                        <hr>

                        <p>
                            <form action="{{ route('sogetrel.passwork.parking', $passwork) }}" method="POST" class="mt-2">
                                @csrf
                                @method('put')

                                <input type="hidden" name="flag_parking" value="{{ $passwork->flag_parking ? '0' : '1' }}">

                                <button type="submit" class="btn btn-block btn-primary" style="text-align: left">
                                    <i class="mr-2 fa {{ $passwork->flag_parking ? 'fa-check-square-o' : 'fa-square-o' }}"></i> {{ __('sogetrel.user.passwork.show.parking') }}
                                </button>
                            </form>
                        </p>
                        <p>
                            <button type="submit" class="btn btn-block btn-warning" data-toggle="modal" data-target="#passwork-pending-modal" style="text-align: left">
                                <i class="mr-2 fa fa-clock-o"></i> {{ __('sogetrel.user.passwork.show.waiting') }}
                            </button>
                        </p>
                        @include('sogetrel.user.passwork.modals._pending_passwork')

                        <p>
                            <button type="submit" class="btn btn-block btn-warning" data-toggle="modal" data-target="#passwork-not_resulted-modal" style="text-align: left">
                                 <i class="mr-2 fa fa-phone"></i> {{ __('sogetrel.user.passwork.show.not_resulted') }}
                            </button>
                        </p>
                        @include('sogetrel.user.passwork.modals._not_resulted_passwork')

                        <form action="{{ route('sogetrel.passwork.contacted', $passwork) }}" method="POST" class="mt-2">
                            @csrf
                            @method('put')

                            <input type="hidden" name="flag_contacted" value="{{ $passwork->flag_contacted ? '0' : '1' }}">

                            <button type="submit" class="btn btn-block btn-primary" style="text-align: left">
                                <i class="mr-2 fa {{ $passwork->flag_contacted ? 'fa-check-square-o' : 'fa-square-o' }}"></i> {{ __('sogetrel.user.passwork.show.contact') }}
                            </button>
                        </form>

                        <hr>

                        <button style ="background: black;" class="btn btn-block mt-2" data-toggle="modal" data-target="#passwork-blacklisted-modal">
                            <span style="color: white;">
                                <i class="mr-2 fa fa-exclamation-triangle"></i>
                                <b>{{ __('sogetrel.user.passwork.show.blacklist') }}</b>
                            </span>
                        </button>
                        @include('sogetrel.user.passwork.modals._blacklisted_passwork')

                        <hr>

                        <p>
                            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#share-modal" style="text-align: left">
                                <i class="mr-2 fa fa-share"></i> {{ __('sogetrel.user.passwork.show.share') }}
                            </button>
                        </p>
                        @include('sogetrel.user.passwork.modals._share')

                        <hr>

                        @component('components.action', [
                            'href' => route('sogetrel.passwork.quizz.index', $passwork),
                            'icon' => "question",
                        ])
                            So'Quizz ({{ count($passwork->quizzes) }})
                        @endcomponent
                        <hr>
                    @endcomponent
                @endif
                @component('components.panel', ['icon' => "list-ol", 'height' => 2])
                    @slot('heading')
                        {{ __('sogetrel.user.passwork.show.follow_up_questions') }}
                    @endslot

                    @foreach($passwork->revisionHistory()->latest()->limit(25)->get() as $history)
                        <div>
                            <i class="fa fa-fw mr-2 text-muted fa-clock-o"></i> @datetime($history->created_at)<br>
                            @if ($history->userResponsible())
                                <i class="fa fa-fw mr-2 text-muted fa-user"></i> {{ $history->userResponsible()->views->link }}<br>
                            @endif

                            <p class="mt-2">
                                changé <i>{{ $history->fieldName() }}</i>
                                @if ($history->fieldName() != 'data')
                                    de <b>{{ $history->oldValue() }}</b>
                                    à <b>{{ $history->newValue() }}</b>
                                @endif
                            </p>
                            <hr>
                        </div>
                    @endforeach
                    </ul>
                @endcomponent
            </div>
            @endif
        @endcan
    </div>
@endsection

@section('scripts')
    @if($errors->has('contract_types'))
        <script>
            $('#passwork-accepted-modal').modal('show')
        </script>
    @endif
@endsection
