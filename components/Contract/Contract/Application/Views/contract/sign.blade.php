@inject('contractRepository', 'Components\Contract\Contract\Application\Repositories\ContractRepository')

@extends('foundation::layout.app.show')

@section('title', "{$contract->name}")

@section('toolbar')
    @button(__('components.contract.contract.application.views.contract.show.return')."|href:".route('contract.show', $contract)."|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    @include('contract::contract._breadcrumb', ['page' => "sign"])
@endsection

@push('stylesheets')
    <style>
        .container {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding-right: 95%;
            padding-top: 56.25% !important;
        }
        .responsive-iframe {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
        }
        @media (min-width: 320px) {
            .container {
                padding-top: 185% !important;
            }
        }
        @media (min-width: 320px) {
            .container {
                padding-top: 185% !important;
            }
        }
        @media (min-width: 360px) {
            .container {
                padding-top: 180% !important;
            }
        }
        @media (min-width: 640px) {
            .container {
                padding-top: 180% !important;
            }
        }
        @media (min-width: 768px) {
            .container {
                padding-top: 210% !important;
            }
        }
        @media (min-width: 768px) {
            .container {
                padding-top: 160% !important;
            }
        }
        @media (min-width: 1024px) {
            .container {
                padding-top: 175% !important;
            }
        }
        @media (min-width: 1200px) {
            .container {
                padding-top: 175% !important;
            }
        }
        @media (min-width: 1400px) {
            .container {
                padding-top: 56% !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <iframe class="responsive-iframe" src="{{ $signatureUi }}"></iframe>
    </div>
@endsection
