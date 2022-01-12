@extends('foundation::layout.app.index')

@section('title', __('soprema.enterprise.covid19_form_answer.index.covid19'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('soprema.enterprise.covid19_form_answer.index.dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('soprema.enterprise.covid19_form_answer.index.soprema') }}</li>
    <li class="breadcrumb-item active">{{ __('soprema.enterprise.covid19_form_answer.index.responses_to_covid19_form') }}</li>
@endsection

@section('table.head')
    <th>{{ __('soprema.enterprise.covid19_form_answer.index.service_provider') }}</th>
    <th>{{ __('soprema.enterprise.covid19_form_answer.index.clients') }}</th>
    <th class="text-center">{{ __('soprema.enterprise.covid19_form_answer.index.activity_retake') }}</th>
    <th class="text-right">{{ __('soprema.enterprise.covid19_form_answer.index.actions') }}</th>
@endsection

@section('table.pagination')
    {{ $items->links() }}
@endsection

@section('form')
    <div class="row">
        <div class="col-md-4">
            @form_group([
                'text'         => __('soprema.enterprise.covid19_form_answer.index.client'),
                'type'         => "select",
                'name'         => 'enterprise',
                'options'      => $subsidiaries,
                'value'        => request('enterprise'),
                'selectpicker' => true,
                'search'       => true,
            ])
        </div>

        <div class="col-md-4">
            @form_group([
                'text'         => __('soprema.enterprise.covid19_form_answer.index.activity_retake'),
                'type'         => "select",
                'name'         => 'pursuit',
                'options'      => [1 => __('soprema.enterprise.covid19_form_answer.index.yes'), 0 => __('soprema.enterprise.covid19_form_answer.index.no')],
                'value'        => request('pursuit'),
            ])
        </div>
    </div>

    <div class="text-right">
        @button(__('soprema.enterprise.covid19_form_answer.index.filter')."|icon:filter|color:primary|type:submit")
    </div>
@endsection

@section('table.body')
    @forelse ($items as $covid19_form_answer)
        <tr>
            <td>
                @if ($covid19_form_answer->vendor->exists)
                    {{ $covid19_form_answer->vendor->views->link }}<br>
                    <small>{{ $covid19_form_answer->vendor->identification_number }}</small>
                @else
                    {{ $covid19_form_answer->vendor_name }}<br>
                    <small>{{ $covid19_form_answer->vendor_siret }}</small>
                @endif
            </td>
            <td>
                @if ($covid19_form_answer->vendor->exists)
                    @foreach ($covid19_form_answer->vendor->customers as $customer)
                        {{ $customer->views->link }} @unless($loop->last) <br> @endunless
                    @endforeach
                @else
                    {{ $covid19_form_answer->customer->views->link }}
                @endif
            </td>
            <td class="text-center">
                @bool($covid19_form_answer->pursuit)
            </td>
            <td class="text-right">
                {{ $covid19_form_answer->views->actions }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="999">@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
