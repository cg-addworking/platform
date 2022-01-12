@extends('foundation::layout.app.show')

@section('title', $user->name)

@section('toolbar')
    @button(__('addworking.enterprise.member.show.return')."|icon:arrow-left|color:secondary|outline|sm|mr:2|href:".route('addworking.enterprise.member.index', compact('enterprise')))
    @can('editMember', $enterprise)
        @button(__('addworking.enterprise.member.show.edit')."|icon:edit|color:outline-success|outline|sm|mr:2|href:".route('addworking.enterprise.member.edit', compact('enterprise', 'user')))
    @endcan
    @if(auth()->user()->isSupport())
        @button(__('addworking.enterprise.member.show.to_log_in')."|href:".route('impersonate', $user)."|icon:magic|color:outline-success|outline|sm|mr:2")
    @endif
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.member.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item("Entreprises|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.member.show.company_members')."|href:".route('addworking.enterprise.member.index', compact('enterprise')))
    @breadcrumb_item("{$user->name}|active")
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            @attribute("{$user->enterprises()->find($enterprise->id)->pivot->job_title}|icon:user-tie|label:".__('addworking.enterprise.member.show.title'))
            @component('bootstrap::attribute', ['icon' => "user", 'label' => __('addworking.enterprise.member.show.identity')])
                {{ $user->views->link }}
            @endcomponent
            @component('bootstrap::attribute', ['icon' => "clock", 'label' => __('addworking.enterprise.member.show.become_member')])
                {{ optional($user->enterprises()->find($enterprise->id)->pivot->created_at)->diffForHumans() ?? 'n/a' }}
            @endcomponent
        </div>

        <div class="col-md-6">
            @can('readMemberRoles', $enterprise)
                @component('bootstrap::attribute', ['icon' => "user-tag", 'label' => "Roles"])
                    <div class="row">
                        <div class="col-md-2">
                            @include('addworking.enterprise.member._member_roles', compact('user'))<br>
                        </div>
                    </div>
                @endcomponent
            @endcan

            @can('readMemberAccess', $enterprise)
                @component('bootstrap::attribute', ['icon' => 'user-shield', 'label' => __('addworking.enterprise.member.show.access')])
                    <div class="row">
                        <div class="col-md-6">
                            <span>{{ __('addworking.enterprise.member.show.access_invoicing') }}</span><br>
                            <span>{{ __('addworking.enterprise.member.show.access_mission') }}</span><br>
                            <span>{{ __('addworking.enterprise.member.show.access_contracts') }}</span><br>
                            <span>{{ __('addworking.enterprise.member.show.access_purchase_order') }}</span><br>
                            <span>{{ __('addworking.enterprise.member.show.access_company_information') }}</span><br>
                            <span>{{ __('addworking.enterprise.member.show.access_company_user') }}</span><br>
                        </div>
                        <div class="col-md-2">
                            @bool($user->hasAccessFor($enterprise, user()::ACCESS_TO_BILLING))<br>
                            @bool($user->hasAccessFor($enterprise, user()::ACCESS_TO_MISSION))<br>
                            @bool($user->hasAccessFor($enterprise, user()::ACCESS_TO_CONTRACT))<br>
                            @bool($user->hasAccessFor($enterprise, user()::ACCESS_TO_MISSION_PURCHASE_ORDER))<br>
                            @bool($user->hasAccessFor($enterprise, user()::ACCESS_TO_ENTERPRISE))<br>
                            @bool($user->hasAccessFor($enterprise, user()::ACCESS_TO_USER))<br>
                        </div>
                    </div>
                @endcomponent
            @endcan
        </div>
    </div>
@endsection
