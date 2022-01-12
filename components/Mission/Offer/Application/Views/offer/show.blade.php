@inject('responseRepository', 'Components\Mission\Offer\Application\Repositories\ResponseRepository')

@extends('foundation::layout.app.show')

@section('title', $offer->getLabel())

@section('toolbar')
    @button(__('offer::offer.show.return')."|href:#|icon:arrow-left|color:secondary|outline|sm|mr:2")

    @can('close', $offer)
        <a class="btn btn-outline-success btn-sm mr-2" href="#" onclick="confirm('{{ __('offer::offer.show.confirm_closing_offer') }}') && document.forms['{{ $name = uniqid('form_') }}'].submit()">
            @icon('check|color:success|mr:1') {{ __('offer::offer.show.close_offer') }}
        </a>
        @push('modals')
            <form name="{{ $name }}" action="{{ route('sector.offer.close', $offer) }}" method="GET">
                @csrf
            </form>
        @endpush
    @endcan

    @can('create', [get_class($responseRepository->make()), $offer])
        @button(__('offer::offer.show.respond')."|href:".route('sector.response.create', $offer)."|icon:edit|color:success|outline|sm|mr:2")
    @else
        @if(! auth()->user()->enterprise->isCustomer())
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{__('offer::offer.show.no_possible_response')}}">
                <a role="button" href="#" class="btn btn-outline-success btn-sm mr-2 disabled" disabled>
                    @icon('edit') {{ __('offer::offer.show.respond') }}
                </a>
            </span>
        @endif
    @endcan

    @can('sendToEnterprise', [$offer])
        @button(__('offer::offer.show.send_to_enterprise')."|href:".route('sector.offer.send_to_enterprise', $offer)."|icon:plus|color:primary|outline|sm|mr:2")
    @endcan

    @can('index', [get_class($responseRepository->make()), $offer])
        @button(__('offer::offer.show.responses')."|href:".route('sector.response.index', $offer)."|icon:reply-all|color:secondary|outline|sm|mr:2")
    @endcan

    @include('offer::offer._actions')
@endsection

@section('breadcrumb')
    @include('offer::offer._breadcrumb', ['page' => "show"])
@endsection

@section('content')
    @include('offer::offer.construction._html')
@endsection
