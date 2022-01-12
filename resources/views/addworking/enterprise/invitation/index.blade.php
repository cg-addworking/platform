@inject('invitationRepository', "App\Repositories\Addworking\Enterprise\InvitationRepository")

@extends('foundation::layout.app.index')

@section('title', __('addworking.enterprise.invitation.index.my_invitations'))

@section('toolbar')
    @can('inviteVendor', $enterprise)
        @button(__('addworking.enterprise.invitation.index.invite_provider')."|icon:user-plus|color:primary|outline|sm|mr:2|href:".route('addworking.enterprise.vendor.invitation.create', compact('enterprise')))
    @endcan

    @can('inviteMember', $enterprise)
        @button(__('addworking.enterprise.invitation.index.invite_member')."|icon:user-plus|color:primary|outline|sm|mr:2|href:".route('addworking.enterprise.member.invitation.create', compact('enterprise')))
    @endcan

    @can('relaunchInvitationInBatch', $enterprise)
        @button(__('addworking.enterprise.invitation.index.index_relaunch')."|icon:redo-alt|color:primary|outline|sm|mr:2|href:".route('addworking.enterprise.invitation.index_relaunch', compact('enterprise')))
    @endcan

    @button(__('addworking.enterprise.invitation.index.return')."|icon:arrow-left|color:secondary|outline|sm|mr:2|href:".route('dashboard'))
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.invitation.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.enterprise.invitation.index.enterprise')."|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.invitation.index.my_invitations')."|active")
@endsection

@section('form')
    @include('addworking.enterprise.invitation._index_form')
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.head')
    @include('addworking.enterprise.invitation._table_head')
@endsection

@section('table.filter')
    @include('addworking.enterprise.invitation._table_filter')
@endsection

@section('table.colgroup')
    @include('addworking.enterprise.invitation._table_colgroup')
@endsection

@section('table.body')
    @forelse ($items as $invitation)
        <tr>
            <td>
                @if($invitation->guest->exists)
                    @link($invitation->guest)
                @else
                    {{$invitation->contact_name}}
                @endif
                {{ __('addworking.enterprise.invitation.index.of') }}
                @if($invitation->guestEnterprise->exists)
                    @link($invitation->guestEnterprise)
                @else
                    {{$invitation->contact_enterprise_name}}
                @endif

                <br/>

                <small class="text-muted">
                    <b>{{ $invitation->valid_until->isPast() ? __('addworking.enterprise.invitation.index.expired') : __('addworking.enterprise.invitation.index.expire', ['date' => $invitation->valid_until->diffForHumans()])}}</b>
                </small>
            </td>
            <td>
                <span class="text-secondary">{{ $invitation->contact }}</span>
            </td>
            <td>
                @include('addworking.enterprise.invitation._invitation_status')
            </td>
            <td>
                @include('addworking.enterprise.invitation._invitation_types')
            </td>
            <td class="text-right">
                @include('addworking.enterprise.invitation._actions')
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="99" class="text-center">
                <div class="p-5">
                    <i class="fa fa-frown-o"></i> @lang('messages.empty')
                </div>
            </td>
        </tr>
    @endforelse
@endsection
