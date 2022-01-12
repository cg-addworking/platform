@extends('foundation::layout.app.index')

@section('title', __('addworking.enterprise.member.index.company_members'))

@section('toolbar')
    @can('addMember', $enterprise)
        @button(__('addworking.enterprise.member.index.refer_user')."|icon:user-plus|color:primary|outline|sm|mr:2|href:".route('addworking.enterprise.member.create', $enterprise))
    @endcan

    @can('inviteMember', $enterprise)
        @button(__('addworking.enterprise.member.index.invite_member')."|icon:user-plus|color:primary|outline|sm|mr:2|href:".route('addworking.enterprise.member.invitation.create', $enterprise))
    @endcan

    @button(__('addworking.enterprise.member.index.return')."|href:{$enterprise->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.member.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item("Entreprises|href:{$enterprise->routes->index}")
    @breadcrumb_item("{$enterprise->name}|href:{$enterprise->routes->show}")
    @breadcrumb_item(__('addworking.enterprise.member.index.company_members')."|active")
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.head')
    @include('addworking.enterprise.member._table_head')
@endsection

@section('table.filter')
    @include('addworking.enterprise.member._table_filter')
@endsection

@section('table.colgroup')
    @include('addworking.enterprise.member._table_colgroup')
@endsection

@section('table.body')
    @forelse ($items as $user)
        <tr>
            <td>
                @link($user)<br>
                <small class="text-muted">
                    <b class="text-danger">{{ $user->getJobTitleFor($enterprise) }}</b>
                    depuis
                    <b>@date($user->getMemberSinceFor($enterprise))</b>
                </small>
            </td>

            @can('readMemberRoles', $enterprise)
                <td>
                    @include('addworking.enterprise.member._member_roles')
                </td>
            @endcan

            @can('readMemberAccess', $enterprise)
                <td>
                    @include('addworking.enterprise.member._member_accesses')
                </td>
            @endcan

            <td class="text-right">
                @include('addworking.enterprise.member._actions')
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
