@extends('foundation::layout.app.show')

@section('title', __('addworking.enterprise.invitation.show.invitation_for')." {$invitation->email}")

@section('toolbar')
    @can('relaunchInvitation', [$enterprise, $invitation])
        @button(__('addworking.enterprise.invitation.show.revive')."|icon:redo-alt|color:primary|outline|sm|mr:2|href:".route('addworking.enterprise.invitation.relaunch', compact('enterprise', 'invitation')))
    @endcan

    @button(__('addworking.enterprise.invitation.show.return')."|icon:arrow-left|color:secondary|outline|sm|mr:2|href:".route('addworking.enterprise.invitation.index', compact('enterprise')))
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.invitation.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.invitation.show.enterprise')."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.invitation.show.my_invitations')."|href:".route('addworking.enterprise.invitation.index', compact('enterprise')))
    @breadcrumb_item(__('addworking.enterprise.invitation.show.invitation_for')." {$invitation->email}|active")
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            @component('bootstrap::attribute', ['icon' => "user", 'label' => __('addworking.enterprise.invitation.show.guest')])
                @link($invitation->guest)
            @endcomponent
            @component('bootstrap::attribute', ['icon' => 'building', 'label' => __('addworking.enterprise.invitation.show.enterprise')])
                @link($invitation->guestEnterprise)
            @endcomponent
            @attribute("{$invitation->contact}|icon:envelope|label:Email")
            @component('bootstrap::attribute', ['icon' => 'calendar-times', 'label' => $invitation->valid_until->isPast() ? __('addworking.enterprise.invitation.show.expired_on') : __('addworking.enterprise.invitation.show.expires_on')])
                @date($invitation->valid_until)
            @endcomponent
        </div>
        <div class="col-md-6">
            @component('bootstrap::attribute', ['icon' => 'user-tag', 'label' => __('addworking.enterprise.invitation.show.type')])
                @include('addworking.enterprise.invitation._invitation_types')
            @endcomponent
            @component('bootstrap::attribute', ['icon' => 'tag', 'label' => __('addworking.enterprise.invitation.show.status')])
                @include('addworking.enterprise.invitation._invitation_status')
            @endcomponent
        </div>
    </div>
@endsection
