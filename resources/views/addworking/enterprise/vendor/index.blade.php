@inject('enterpriseRepository', 'App\Repositories\Addworking\Enterprise\EnterpriseRepository')

@extends('foundation::layout.app.index')

@php
    $document_type_business_count = document_type([])->whereHas('enterprise', function ($query) use ($enterprise) {
            return $query->whereIn('id', $enterprise->ancestors()->push($enterprise)->pluck('id'));
        })->ofType(document_type([])::TYPE_BUSINESS)->mandatory()->count();
@endphp

@section('title', __('addworking.enterprise.vendor.index.my_providers'))

@section('toolbar')
    @button(__('addworking.enterprise.vendor.index.return')."|href:".route('enterprise.show', $enterprise)."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @if ($enterprise->activityPeriods->count() > 0)
        @button(__('addworking.enterprise.vendor.index.dedicated_resources')."|href:".route('addworking.enterprise.assigned_resource.index', $enterprise)."|icon:eye|color:outline-primary|outline|sm|mr:2")
    @endif
    @button(__('addworking.enterprise.vendor.index.export')."|href:".route('addworking.enterprise.vendor.export', $enterprise).'?'.http_build_query(request()->all())."|icon:file-export|color:outline-primary|outline|sm|mr:2")
    @can('importVendor', $enterprise)
        @button(__('addworking.enterprise.vendor.index.import')."|href:".route('addworking.enterprise.vendor.import', $enterprise)."|icon:upload|color:outline-primary|outline|sm|mr:2")
    @endcan

    @if ($enterpriseRepository->hasJobs($enterprise))
        @button(__('addworking.enterprise.vendor.index.division_by_skills')."|href:".route('addworking.enterprise.vendor.index_division_by_skills', $enterprise)."|icon:chart-pie
|color:outline-primary|outline|sm|mr:2")
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('addworking.enterprise.vendor.index.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ $enterprise->routes->index }}">{{ __('addworking.enterprise.vendor.index.enterprise') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ $enterprise->routes->show }}">{{ $enterprise->name }}</a></li>
    <li class="breadcrumb-item active">{{ __('addworking.enterprise.vendor.index.my_providers') }}</li>
@endsection

@can('seeMyVendors', $enterprise)
    @section('table.filter')
        @parent
        @form_control([
            'class'       => "pb-2",
            'text'        => __('addworking.enterprise.vendor.index.see_only_assigned_providers'),
            'type'        => "switch",
            'name'        => "show-my-vendors",
            '_attributes' => ['onChange' => "this.form.submit()"] + (request()->has('show-my-vendors') ? ['checked' => 'checked'] : []),
        ])
    @endsection
@endcan

@section('table.head')
    @th(__('addworking.enterprise.vendor.index.society')."|column:name")
    @th(__('addworking.enterprise.vendor.index.leader')."|not_allowed")
    @support
        @th(__('addworking.enterprise.vendor.index.onboarding_status')."|class:text-center|not_allowed")
    @endsupport
    @th(__('addworking.enterprise.vendor.index.legal_documents_compliance')."|class:text-center|not_allowed")
    @if($document_type_business_count)
        @th(__('addworking.enterprise.vendor.index.business_documents_compliance')."|class:text-center|not_allowed")
    @endif
    @th(__('addworking.enterprise.vendor.index.action')."|not_allowed|class:text-right")
@endsection

@section('table.filter')
    <td><input class="form-control form-control-sm" type="text" name="filter[name]" value="{{ request()->input('filter.name') }}"></td>
    <td><input class="form-control form-control-sm" type="text" name="filter[legal_representative]" value="{{ request()->input('filter.legal_representative') }}"></td>
    @support<td></td>@endsupport
    <td></td>
    @if($document_type_business_count)
        <td></td>
    @endif
    <td><button class="btn btn-sm btn-primary btn-block" type="submit">@icon('check')</button></td>
@endsection

@section('table.pagination')
    {{ $items->appends(request()->except('page'))->links() }}
@endsection

@section('table.body')
    @foreach ($items as $vendor)
        <tr>
            <td>
                <a href="{{ route('addworking.enterprise.vendor.partnership.edit', [$enterprise, $vendor]) }}">
                    @if($vendor->vendorInActivityWithCustomer($enterprise))
                        <span class="badge badge-pill badge-success mr-3" data-toggle="tooltip" data-placement="top" title="Ce prestataire est actuellement actif">{{ __('addworking.enterprise.vendor.index.active') }}</span>
                    @else
                        <span class="badge badge-pill badge-secondary mr-2" data-toggle="tooltip" data-placement="top" title="Ce prestataire est actuellement inactif">{{ __('addworking.enterprise.vendor.index.inactive') }}</span>
                    @endif
                </a>
                {{ $vendor->views->link }}
            </td>
            <td>{{ optional(optional($vendor->legalRepresentatives->first())->views)->link }}</td>
            @support
                <td class="text-center">
                    @php
                        $onboarding_process = $vendor->legalRepresentatives()->firstOrNew([])->onboardingProcesses()->latest()->firstOrNew([]);
                    @endphp

                    @if($onboarding_process->exists)
                        @if($onboarding_process->complete)
                            <i class="fas fa-check-square text-success fa-2x" tabindex="0" data-toggle="popover" data-trigger="hover" data-content="{{ __('addworking.enterprise.vendor.index.onboarding_completed') }}"></i>
                        @else
                            <i class="fas fa-caret-square-right fa-2x text-primary" tabindex="0" data-toggle="popover" data-trigger="hover" data-content="{{ __('addworking.enterprise.vendor.index.onboarding_inprogress') }} {{ $onboarding_process->current_step."/".$onboarding_process->last_step }} : @lang('addworking/user/onboarding_process.step.' . $onboarding_process->getCurrentStep()->getName())"></i>
                        @endif
                    @else
                        <i class="fas fa-exclamation-circle text-danger fa-2x" tabindex="0" data-toggle="popover" data-trigger="hover" data-content="{{ __('addworking.enterprise.vendor.index.onboarding_non_existent') }}"></i>
                    @endif
                </td>
            @endsupport
            <td class="text-center">
                <a href="{{ route('addworking.enterprise.document.index', $vendor) }}">
                    @if($vendor->isReadyToWorkFor(enterprise([])::addworking(), document_type([])::TYPE_LEGAL) && $vendor->isReadyToWorkFor($enterprise, document_type([])::TYPE_LEGAL))
                        <i class="fas fa-check-circle fa-2x text-success" tabindex="0" data-toggle="popover" data-trigger="hover" data-content="{{ __('addworking.enterprise.vendor.index.complaint_service_provider') }}"></i>
                    @else
                        <i class="fas fa-times-circle fa-2x text-danger" tabindex="0" data-toggle="popover" data-trigger="hover" data-content="{{ __('addworking.enterprise.vendor.index.non_complaint_service_provider') }}"></i>
                    @endif
                </a>
            </td>
            @if($document_type_business_count)
                <td class="text-center">
                    <a href="{{ route('addworking.enterprise.document.index', $vendor) }}">
                        @if($vendor->isReadyToWorkFor(enterprise([])::addworking(), document_type([])::TYPE_BUSINESS) && $vendor->isReadyToWorkFor($enterprise, document_type([])::TYPE_BUSINESS))
                            <i class="fas fa-check-circle fa-2x text-success" tabindex="0" data-toggle="popover" data-trigger="hover" data-content="{{ __('addworking.enterprise.vendor.index.complaint_service_provider') }}"></i>
                        @else
                            <i class="fas fa-times-circle fa-2x text-danger" tabindex="0" data-toggle="popover" data-trigger="hover" data-content="{{ __('addworking.enterprise.vendor.index.non_complaint_service_provider') }}"></i>
                        @endif
                    </a>
                </td>
            @endif
            <td class="text-right">
                @include('addworking.enterprise.vendor._actions')
            </td>
        </tr>
    @endforeach
@endsection
