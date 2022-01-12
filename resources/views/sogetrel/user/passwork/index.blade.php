@extends('foundation::layout.app.show')

@section('title', __('sogetrel.user.passwork.index.my_subcontractors'))

@section('breadcrumb')
    @breadcrumb_item(__('sogetrel.user.passwork.index.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item(__('sogetrel.user.passwork.index.my_subcontractors')."|active")
@endsection

@section('toolbar')
    @can('index', sogetrel_passwork_acceptation())
        @button(__('sogetrel.user.passwork.index.acceptation')."|href:".route('sogetrel.passwork.acceptation.index')."|icon:list-alt|color:primary|outline|sm|mr:2")
    @endcan
    @button(__('sogetrel.user.passwork.index.return')."|icon:arrow-left|color:secondary|outline|sm|href:".route('dashboard'))
@endsection

@section('content')
    @include('sogetrel.user.passwork._search')
    <div class="input-group-text rounded bg-light border-0 mb-2"><b>{{ $passworks->total() }}</b>&nbsp;{{ __('sogetrel.user.passwork.index.objects_found') }}</div>

    <div class="table-responsive">
            @section('table')
                <table class="table table-hover" id="enterprise-list">
                    <thead>
                    <tr>
                        <th>{{ __('sogetrel.user.passwork.index.enterprise') }}</th>
                        <th>{{ __('sogetrel.user.passwork.index.representative') }}</th>
                        <th class="text-center">{{ __('sogetrel.user.passwork.index.number_of_employees') }}</th>
                        <th class="text-center">{{ __('sogetrel.user.passwork.index.electrician') }}</th>
                        <th class="text-center"><abbr title="Technicien Multi Activités">{{ __('sogetrel.user.passwork.index.technician') }}</abbr></th>
                        <th class="text-center">{{ __('sogetrel.user.passwork.index.design_office') }} </th>
                        <th class="text-center">{{ __('sogetrel.user.passwork.index.civil_engineering') }} </th>
                        <th>{{ __('sogetrel.user.passwork.index.departments') }}</th>
                        <th>{{ __('sogetrel.user.passwork.index.status') }}</th>
                        <th class="text-right">{{ __('sogetrel.user.passwork.index.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($passworks as $passwork)
                        <tr>
                            <td>{{ optional($passwork->user->enterprise)->views->link ?? 'n/a' }}</td>
                            <td>{{ optional($passwork->user)->views->link ?? 'n/a' }}</td>
                            <td class="text-center">{{ array_get($passwork->data, 'enterprise_number_of_employees') ?: 'n/a' }}</td>
                            <td class="text-center">@bool(array_get($passwork->data, 'electrician'))</td>
                            <td class="text-center">@bool(array_get($passwork->data, 'multi_activities'))</td>
                            <td class="text-center">@bool(array_get($passwork->data, 'engineering_office'))</td>
                            <td class="text-center">@bool(array_get($passwork->data, 'civil_engineering'))</td>
                            <td>@include('sogetrel.user.passwork._departments')</td>
                            <td>@include('sogetrel.user.passwork._status')</td>
                            <td class="text-right">{{ $passwork->views->actions }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @show

            {{ $passworks->appends(request()->except('page'))->links() }}
        </div>
@endsection
