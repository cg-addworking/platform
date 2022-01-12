@inject('invoiceParameterRepository', 'Components\Billing\PaymentOrder\Application\Repositories\InvoiceParameterRepository')

@form_group([
    'text'     => "Nom du client",
    'type'     => "text",
    'required' => true,
    'name'     => "payment_order.customer_name",
    'value'    => optional($payment_order)->getCustomerName() ?? $enterprise->name
])

<div class="form-group">
    <label>
        {{__('payment_order::payment_order.form.iban')}} <sup class=" text-danger font-italic">*</sup>
    </label>
    <select data-live-search="1" class="form-control shadow-sm selectpicker"  name="payment_order[iban_id]">
        <option value=""> {{__('payment_order::payment_order.form.no_selection')}} </option>
        @foreach($addworking_ibans as $iban_id => $iban_label)
            <option value="{{ $iban_id }}" @if($payment_order->getIban() && $payment_order->getIban()->id === $iban_id) selected @endif> {{ $iban_label }} </option>
        @endforeach
    </select>
</div>

@form_group([
    'text'     => "Date d'exécution",
    'type'     => "date",
    'required' => true,
    'name'     => "payment_order.executed_at",
    'value'    => optional($payment_order)->getExecutedAt()
])
