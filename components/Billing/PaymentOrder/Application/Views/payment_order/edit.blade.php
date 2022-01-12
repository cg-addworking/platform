@inject('paymentOrderRepository', 'Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderRepository')

@extends('foundation::layout.app.edit', ['action' => route('addworking.billing.payment_order.update', [$enterprise, $payment_order])])

@section('title', "Modifier l'ordre de paiement N° {$payment_order->getNumber()}")

@section('toolbar')
    @button("Retour|href:".route('addworking.billing.payment_order.show', [$enterprise, $payment_order])."|icon:arrow-left|color:secondary|outline|sm")
@endsection

@section('breadcrumb')
    @include('payment_order::payment_order._breadcrumb', ['page' => "edit"])
@endsection

@section('form')
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                @include('payment_order::payment_order._form')

                @form_group([
                    'text'     => "Statut",
                    'type'     => "select",
                    'options'  => $paymentOrderRepository->getStatuses(),
                    'required' => true,
                    'name'     => 'payment_order.status',
                    'value'    => $payment_order->getStatus()
                ])

                @form_group([
                    'text'     => "Référence bancaire",
                    'type'     => "text",
                    'required' => false,
                    'name'     => "payment_order.bank_reference_payment",
                    'value'    => optional($payment_order)->getBankReferencePayment()
                ])

            </div>
        </div>
    </fieldset>
    <div class="text-right my-5">
        @button("Modifier l'ordre de paiement|type:submit|color:success|shadow|icon:check")
    </div>
@endsection