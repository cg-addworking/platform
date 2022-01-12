@extends('foundation::layout.app.index')

@section('title', __('addworking.user.onboarding_process.index.onboarding_process'))

@section('toolbar')
    @button(__('addworking.user.onboarding_process.index.return')."|href:".route('dashboard')."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @button(__('addworking.user.onboarding_process.index.add')."|href:".route('support.user.onboarding_process.create')."|icon:plus|color:outline-success|outline|sm")
    @button(__('addworking.user.onboarding_process.index.export')."|href:".route('support.user.onboarding_process.export')."?".http_build_query(request()->all())."|icon:file-excel|color:primary|outline|sm|ml:2")
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.user.onboarding_process.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('addworking.user.onboarding_process.index.onboarding_process')."|active")
@endsection

@section('table.head')
    @th(__('addworking.user.onboarding_process.index.user')."|not_allowed")
    @th(__('addworking.user.onboarding_process.index.entreprise')."|not_allowed")
    @th(__('addworking.user.onboarding_process.index.client')."|not_allowed")
    @th(__('addworking.user.onboarding_process.index.concerned_domain')."|not_allowed")
    @th(__('addworking.user.onboarding_process.index.status')."|not_allowed")
    @th(__('addworking.user.onboarding_process.index.created')."|column:created_at")
    @th(__('addworking.user.onboarding_process.index.step_in_process')."|not_allowed")
    @th(__('addworking.user.onboarding_process.index.action')."|not_allowed|class:text-right")
@endsection

@section('table.filter')
    <td><input class="form-control form-control-sm" type="text" name="filter[user]" value="{{ request()->input('filter.user') }}"></td>
    <td><input class="form-control form-control-sm" type="text" name="filter[enterprise]" value="{{ request()->input('filter.enterprise') }}"></td>
    <td><input class="form-control form-control-sm" type="text" name="filter[customer]" value="{{ request()->input('filter.customer') }}"></td>
    <td>
        @form_control([
            'class'   => "form-control form-control-sm",
            'type'    => "select",
            'name'    => "filter[domain]",
            'options' => onboarding_process('')::getAvailableEnterprises(),
            'value'   => request()->input('filter.domain'),
        ])
    </td>
    <td>
        <select class="form-control form-control-sm" name="filter[status]">
            <option></option>
            <option value="false" @if(request()->input('filter.status') == 'false') selected @endif>{{ __('addworking.user.onboarding_process.index.in_progress') }}</option>
            <option value="true" @if(request()->input('filter.status') == 'true') selected @endif>{{ __('addworking.user.onboarding_process.index.finish') }}</option>
        </select>
    </td>
    <td><input class="form-control form-control-sm" type="date" name="filter[created_at]" value="{{ request()->input('filter.created_at') }}"></td>
    <td></td>
    <td><button class="btn btn-sm btn-primary btn-block" type="submit">@icon('check')</button></td>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('table.body')
    @foreach ($items as $process)
        <tr>
            <td>{{ $process->user->views->link }}</td>
            <td>{{ optional(optional($process->user->enterprise)->views)->link }}</td>
            <td>{{ optional(optional($process->user->enterprise->customers()->first())->views)->link }}</td>
            <td>{{ $process->enterprise->name }}</td>
            <td>
                @if($process->complete)
                    <span class="text-success font-weight-bold">Terminé</span>
                @else
                    <span class="text-primary font-weight-bold">En cours</span>
                @endif
            </td>
            <td>@date($process->created_at)</td>
            <td>{{ $process->getCurrentStep()->getDisplayName() }}</td>
            <td class="text-right">{{ $process->views->actions }}</td>
        </tr>
    @endforeach
@endsection
