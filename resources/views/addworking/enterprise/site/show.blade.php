@extends('foundation::layout.app.show')

@section('title', $site->display_name)

@section('toolbar')
    @button(__('addworking.enterprise.site.show.return')."|href:".$enterprise->routes->show."|icon:arrow-left|color:secondary|outline|sm|ml:2")
    {{ $site->views->actions }}
@endsection

@section('breadcrumb')
    @breadcrumb_item(__('addworking.enterprise.site.show.dashboard')."|href:".route('dashboard'))
    @breadcrumb_item($enterprise->name .'|href:'.$enterprise->routes->show )
    @breadcrumb_item('Sites|href:'.$site->routes->index )
    @breadcrumb_item($site->display_name ."|active")
@endsection

@section('tabs')
    <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">{{ __('addworking.enterprise.site.show.general_information') }}</a>
    <a class="nav-item nav-link" id="nav-phone-number-tab" data-toggle="tab" href="#nav-phone-number" role="tab" aria-controls="nav-phone-number" aria-selected="true">{{ __('addworking.enterprise.site.show.phone_numbers') }}</a>
@endsection

@section('content')
    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
        <div class="row">
            @attribute("{$site->display_name}|class:col-md-6|icon:user|label:Nom")
            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "user"])
                @slot('label')
                    {{ __('addworking.enterprise.site.show.analytical_code') }}
                @endslot
                {{ $site->analytic_code ?: 'n/a' }}
            @endcomponent
            @component('bootstrap::attribute', ['class' => "col-md-6", 'icon' => "user"])
                @slot('label')
                    {{ __('addworking.enterprise.site.show.address') }}
                @endslot
                {{ $site->addresses->first() ?: 'n/a' }}
            @endcomponent
        </div>
    </div>
    <div class="tab-pane fade show" id="nav-phone-number" role="tabpanel" aria-labelledby="nav-phone-number-tab">
        <div class="table-responsive">
            <table class="table table-hover">
                <colgroup>
                    <col width="20%">
                    <col width="50%">
                    <col width="20%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <th>{{ __('addworking.enterprise.site.show.phone_number') }}</th>
                    <th>Note</th>
                    <th>{{ __('addworking.enterprise.site.show.date_added') }}</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                @forelse ($site->phoneNumbers as $phone_number)
                    <tr>
                        <td><a href="tel:{{$phone_number->number}}">{{ $phone_number->number }}</a></td>
                        <td>{{ $phone_number->pivot->note }}</td>
                        <td>@datetime($phone_number->created_at)</td>
                        <td>
                            @can('removePhoneNumbers', $site)
                                <a href="#" onclick="confirm('Confirmer la suppression ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
                                    <i class="text-danger mr-3 fa fa-trash"></i> <span class="text-danger">{{ __('addworking.enterprise.site.show.remove') }}</span>
                                </a>
                                <form name="{{ $name }}" action="{{ route('addworking.enterprise.site.phone_number.destroy', ['enterprise' => $enterprise, 'site' => $site, 'phone_number'=> $phone_number]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>@lang('messages.empty')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="text-right my-5">
            @button(__('addworking.enterprise.site.show.add')."|href:".route('addworking.enterprise.site.phone_number.create', [$enterprise, $site])."|icon:plus|color:outline-success|outline|sm")
        </div>
    </div>
@endsection
