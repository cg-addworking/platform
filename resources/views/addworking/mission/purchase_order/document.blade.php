@extends('layout.purchase_order')

@push('styles')
    <style>
        .footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 40px;
            page-break-before: avoid;
        }

        .footer .pagenum:before {
            content: counter(page);
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .left {
            float:left;
            width: 50%;
            margin-right:10px;
        }

        .right {
            float:right;
            width: 50%;
        }
    </style>
@endpush

@section('content')
    <div class="page">
        @include('addworking.mission.purchase_order.document._header')
        @include('addworking.mission.purchase_order.document._enterprises')
        @include('addworking.mission.purchase_order.document._details')
        @include('addworking.mission.purchase_order.document._shipping_informations')
        @include('addworking.mission.purchase_order.document._total')

        <div class="footer text-right last">
            {{ __('addworking.mission.purchase_order.document.page') }} <span class="pagenum"></span>
        </div>
    </div>


    <div class="page">
        @include('addworking.mission.purchase_order.document._terms')
        <div class="footer text-right last">
            {{ __('addworking.mission.purchase_order.document.page') }} <span class="pagenum"></span>
        </div>
    </div>
@endsection
