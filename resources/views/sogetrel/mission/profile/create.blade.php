@extends('foundation::layout.app.show')

@section('title', __('sogetrel.mission.profile.create.selection')." {$offer->label}")

@section('breadcrumb')
    @breadcrumb_item(__('sogetrel.mission.profile.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('sogetrel.mission.profile.create.enterprises').'|href:'.$offer->customer->routes->index )
    @breadcrumb_item($offer->customer->name .'|href:'.$offer->customer->routes->show )
    @breadcrumb_item(__('sogetrel.mission.profile.create.mission_offers').'|href:'.$offer->routes->index )
    <li class="breadcrumb-item"><a href="{{ $show ?? $offer->routes->show }}">{{ $offer->label }}</a></li>
    @breadcrumb_item(__('sogetrel.mission.profile.create.provider_selection')."|active")
@endsection

@section('toolbar')
    @button(__('sogetrel.mission.profile.create.return')."|icon:arrow-left|color:secondary|outline|sm|href:{$offer->routes->index}")
@endsection

@section('content')

    @include('sogetrel.mission.profile._search')

    <div class="row mb-3 mt-3">
        <div class="col-md-12 text-right">
            @if ($passworks->total() && request()->filled('search'))
                <a href="{{ route('sogetrel.mission.proposal.store.all', $offer)."?".http_build_query(request()->all()) }}" type="button" class="btn btn-sm btn-outline-primary">
                    <i class="fa fa-fw mr-2 fa-plus"></i> {{ __('sogetrel.mission.profile.create.disseminate') }} {{ $passworks->total() }} entreprise(s)
                </a>
            @endif
        </div>
    </div>

    @component('bootstrap::form', ['action' => route($proposal_store ?? 'mission.proposal.store'), 'method' => "post", 'id' => "offer-selection-form"])
        <div class="row mb-3 mt-3">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#add-proposal-{{ $offer->id }}">
                    <i class="fa fa-fw mr-2 fa-plus"></i> {{ __('sogetrel.mission.profile.create.disseminate') }} <b class="checked-count">0</b> entreprise(s) sélectionné(s)
                </button>
            </div>
        </div>

        <input type="hidden" name="mission_offer[id]" value="{{ $offer->id }}">

        <div class="input-group-text rounded bg-light border-0 mb-2"><b>{{ $passworks->total() }}</b>&nbsp;{{ __('sogetrel.mission.profile.create.objects_found') }}</div>

        <div class="table-responsive">
            @section('table')
                <table class="table table-hover" id="enterprise-list">
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="select-all" {{ attr_if($passworks->every(function ($passwork) use ($offer) { return $offer->sogetrelPassworks->contains($passwork); }), ['checked']) }}>
                        </th>
                        <th>{{ __('sogetrel.mission.profile.create.enterprise') }}</th>
                        <th>{{ __('sogetrel.mission.profile.create.representative') }}</th>
                        <th class="text-center">{{ __('sogetrel.mission.profile.create.electrician') }}</th>
                        <th class="text-center"><abbr title="Technicien Multi Activités">{{ __('sogetrel.mission.profile.create.technician') }}</abbr></th>
                        <th class="text-center">{{ __('sogetrel.mission.profile.create.design_office') }} </th>
                        <th class="text-center">{{ __('sogetrel.mission.profile.create.civil_engineering') }} </th>
                        <th>{{ __('sogetrel.mission.profile.create.departments') }}</th>
                        <th>{{ __('sogetrel.mission.profile.create.status') }}</th>
                        <th class="text-center">{{ __('sogetrel.mission.profile.create.selected') }}</th>
                        <th class="text-right">{{ __('sogetrel.mission.profile.create.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($passworks as $passwork)
                        <tr>
                            <td><input type="checkbox" name="vendor[id][]" value="{{ $passwork->user->enterprise->id }}" {{ attr_if($offer->sogetrelPassworks->contains($passwork) || $offer->hasProposalsFor($passwork->user->enterprise), ['checked']) }}></td>
                            <td>{{ optional($passwork->user->enterprise)->views->link ?? 'n/a' }}</td>
                            <td>{{ optional($passwork->user)->views->link ?? 'n/a' }}</td>
                            <td class="text-center">@bool(array_get($passwork->data, 'electrician'))</td>
                            <td class="text-center">@bool(array_get($passwork->data, 'multi_activities'))</td>
                            <td class="text-center">@bool(array_get($passwork->data, 'engineering_office'))</td>
                            <td class="text-center">@bool(array_get($passwork->data, 'civil_engineering'))</td>
                            <td>@include('sogetrel.user.passwork._departments')</td>
                            <td>@include('sogetrel.user.passwork._status')</td>
                            <td class="text-center">
                                @bool($offer->sogetrelPassworks->contains($passwork) || $offer->hasProposalsFor($passwork->user->enterprise))
                            </td>
                            <td class="text-center">
                                <a class="text-muted" target="_blank" href="{{ route('sogetrel.passwork.show', $passwork) }}" @tooltip("Voir le passwork")>
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @show

            @include('addworking.mission.proposal._create')

            {{ $passworks->appends(request()->except('page'))->links() }}
        </div>
    @endcomponent
@endsection

@push('scripts')
    <script>
        function update_checked_counter() {
            var count = $('#enterprise-list input:checkbox:checked:not(#select-all)').length;
            $('.checked-count').text(count);
            $('#offer-selection-form [type=button]')[count == 0 ? 'hide': 'show']();
        }

        $(function () {
            $('#select-all').click(function () {
                $('#enterprise-list input:checkbox').prop('checked', $(this).is(':checked'));
                update_checked_counter();
            });

            $('#enterprise-list input:checkbox').change(update_checked_counter);
            update_checked_counter();
        })
    </script>
@endpush


