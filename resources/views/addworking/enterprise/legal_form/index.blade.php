@extends('foundation::layout.app.index')

@section('title', __('addworking.enterprise.legal_form.index.legal_form'))

@section('toolbar')
    @button(sprintf(__('addworking.enterprise.legal_form.index.add')."|href:%s|icon:plus|color:outline-success|outline|sm", legal_form([])->routes->create))
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('addworking.enterprise.legal_form.index.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('addworking.enterprise.legal_form.index.legal_form') }}</li>
@endsection

@section('table.head')
    @th(__('addworking.enterprise.legal_form.index.wording')."|not_allowed")
    @th(__('addworking.enterprise.legal_form.index.acronym')."|not_allowed")
    @th("Pays|not_allowed")
    @th("Action|not_allowed|class:text-right")
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @forelse ($items as $legal_form)
        <tr>
            <td>{{ $legal_form->display_name }}</td>
            <td>{{ $legal_form->name }}</td>
            <td>{{ $legal_form->country }}</td>
            <td class="text-right">{{ $legal_form->views->actions }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="999">@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
