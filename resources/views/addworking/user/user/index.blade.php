@extends('foundation::layout.app.index')

@section('title', __('addworking.user.user.index.title'))

@section('toolbar')
    @button(__('addworking.user.user.index.add')."|href:".route('user.create')."|icon:plus|color:outline-success|outline|sm")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.user.user.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.user.user.index.users')."|active")
@endsection

@section('form')
    @can('seeCounters', [App\Models\Addworking\User\User::class])
        @include('addworking.user.user._index_form')
    @endcan
@endsection

@section('table.colgroup')
    <col width="20%">
    <col width="20%">
    <col width="20%">
    <col width="20%">
    <col width="15%">
    <col width="5%">
@endsection

@section('table.head')
    @th(__('addworking.user.user.index.name')."|column:lastname")
    @th(__('addworking.user.user.index.email')."|column:email")
    @th(__('addworking.user.user.index.enterprise')."|not_allowed")
    @th(__('addworking.user.user.index.type')."|not_allowed")
    @th(__('addworking.user.user.index.created_at')."|column:created_at")
    @th(__('addworking.user.user.index.action')."|not_allowed|class:text-right")
@endsection

@section('table.filter')
    <td>
        @form_control([
            'type'  => "text",
            'name'  => "filter[name]",
            'value' => request()->input('filter.name')
        ])
    </td>
    <td>
        @form_control([
            'type'  => "text",
            'name'  => "filter[email]",
            'value' => request()->input('filter.email')
        ])
    </td>
    <td>
        @form_control([
            'type'  => "text",
            'name'  => "filter[enterprise]",
            'value' => request()->input('filter.enterprise')
        ])
    </td>
    <td>
        @form_control([
            'type' => "select",
            'name' => "filter[type]",
            'options' => ['vendor' => "Prestataire", 'customer' => "Client", 'support' => "Support"],
            'value' => request()->input('filter.type')
        ])
    </td>
    <td>
        @form_control([
            'type'  => "date",
            'name'  => "filter[created_at]",
            'value' => request()->input('filter.created_at')
        ])
    </td>
    <td>
        @button(['icon' => "check", 'type' => "sumbit"])
    </td>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $user)
        <tr>
            <td><a href="#" data-toggle="collapse" data-target="#user-{{ $user->id }}">{{ $user->name }}</a></td>
            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
            <td>{{ $user->enterprise->views->link }}</td>
            <td>@include('addworking.user.user._badges')</td>
            <td>@datetime($user->created_at)</td>
            <td class="text-center">{{ $user->views->actions }}</td>
        </tr>
        <tr class="collapse bg-light" id="user-{{ $user->id }}">
            <td colspan="6">
                {{ $user->views->html }}
            </td>
        </tr>
    @empty
        <tr>
            <td>@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
