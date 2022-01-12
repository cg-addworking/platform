@extends('foundation::layout.app.show')

@section('title', __('addworking.mission.profile.create.service_provider_selection')." {$offer->label}")

@section('breadcrumb')
    @breadcrumb_item(__('addworking.mission.profile.create.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.mission.profile.create.enterprise')."|href:{$offer->customer->routes->index}" )
    @breadcrumb_item("{$offer->customer->name}|href:{$offer->customer->routes->show}")
    @breadcrumb_item(__('addworking.mission.profile.create.mission_offer')."|href:{$offer->routes->index}")
    <li class="breadcrumb-item"><a href="{{ isset($show) ? $show : $offer->routes->show }}">{{ $offer->label }}</a></li>
    @breadcrumb_item(__('addworking.mission.profile.create.provider_selection')."|active")
@endsection

@section('toolbar')
    @button(__('addworking.mission.profile.create.return')."|icon:arrow-left|color:secondary|outline|sm|href:{$offer->routes->index}")
@endsection

@section('content')
    @component('bootstrap::form', ['method' => "get", 'class' => "mb-5"])
        @form_group([
            'type'         => "select",
            'text'         => __('addworking.mission.profile.create.trades_skill'),
            'name'         => "filter.skills.",
            'value'        => request()->input('filter.skills', []),
            'options'      => $jobs->mapWithKeys(function ($job) { return [$job->display_name => $job->skills->pluck('display_name', 'id')]; }),
            'selectpicker' => true,
            'multiple'     => true,
            'search'       => true
        ])

        <div class="text-right">
            @button("Rechercher|icon:search|type:submit")
        </div>
    @endcomponent

    @component('bootstrap::form', ['action' => route($proposal_store ?? 'mission.proposal.store'), 'method' => "post", 'id' => "offer-selection-form"])
        <div class="row mb-3">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-outline-success" style="display: none" data-toggle="modal" data-target="#add-proposal-{{ $offer->id }}">
                    <i class="fa fa-fw mr-2 fa-plus"></i> {{ __('addworking.mission.profile.create.disseminate_offer') }} <b class="checked-count">0</b> {{ __('addworking.mission.profile.create.selected_company') }}
                </button>
            </div>
        </div>

        <input type="hidden" name="mission_offer[id]" value="{{ $offer->id }}">

        <div class="table-responsive">
            @section('table')
                <table class="table table-striped" id="enterprise-list">
                    <thead>
                    <th>Entreprise</th>
                    <th class="text-center">
                        <input type="checkbox" id="select-all">
                    </th>
                    </thead>
                    <tbody>
                    @forelse ($items as $enterprise)
                        <tr>
                            <td>{{ $enterprise->views->link }}</td>
                            <td class="text-center">
                                @if(!$offer->hasProposalsFor($enterprise))
                                    <input type="checkbox" name="vendor[id][]" value="{{ $enterprise->id }}">
                                @else
                                    <b>Déja envoyée</b>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                <div class="p-5">
                                    <i class="fa fa-frown-o"></i> @lang('messages.empty')
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            @show

            @include('addworking.mission.proposal._create')
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
