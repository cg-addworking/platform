@inject('outboundInvoiceRepository', "Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository")

@extends('foundation::layout.app.show')

@section('title', __('billing.outbound.application.views.show.title')." {$outboundInvoice->getFormattedNumber()}")

@section('toolbar')
    @button(__('billing.outbound.application.views.show.return')."|href:".route('addworking.billing.outbound.index', $enterprise)."|icon:arrow-left|color:secondary|outline|sm|mr:2")
    @can('indexAssociate', [get_class($outboundInvoice), $enterprise, $outboundInvoice])
        @button(__('billing.outbound.application.views.show.vendor_invoices')."|href:".route('addworking.billing.outbound.dissociate', [$enterprise, $outboundInvoice])."|icon:file-invoice|color:outline-success|outline|sm|mr:2")
    @endcan

    @can('validate', $outboundInvoice)
        <button class="btn btn-outline-success btn-sm mr-2" onclick="confirm('Êtes-vous sûr de vouloir valider cette facture ?') && document.forms['{{ $name = uniqid('form_') }}'].submit()" href="#">
            @icon('check|mr:2|color:outline-success')
            {{ __('billing.outbound.application.views.show.validate') }}
        </button>

        @push('forms')
            <form name="{{ $name }}" action="{{ route('addworking.billing.outbound.validate', [$enterprise, $outboundInvoice]) }}" method="POST">
                @method('GET')
                @csrf
            </form>
        @endpush
    @endcan

    @include('outbound_invoice::_actions')
@endsection

@section('breadcrumb')
    @include('outbound_invoice::_breadcrumb', ['page' => "show"])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    @if ($outboundInvoiceRepository->hasFile($outboundInvoice))
                        {{ $outboundInvoice->getFile()->views->iframe(['ratio' => "4by3"]) }}
                    @else
                        <div class="text-center"><b>{{ __('billing.outbound.application.views.show.text') }}</b></div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @include('outbound_invoice::_html')
        </div>
    </div>
@endsection
