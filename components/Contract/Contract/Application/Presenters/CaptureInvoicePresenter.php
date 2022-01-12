<?php

namespace Components\Contract\Contract\Application\Presenters;

class CaptureInvoicePresenter
{
    public function present($invoices)
    {
        $data = [];

        foreach ($invoices as $invoice) {
            $data[$invoice->getId()] = [
                'id' => $invoice->getId(),
                'number' => $invoice->getInvoiceNumber(),
                'amount_before_taxes' => $invoice->getInvoiceAmountBeforeTaxes(),
                'amount_of_taxes' => $invoice->getInvoiceAmountOfTaxes(),
                'deposit_guaranteed_holdback_number' => $invoice->getDepositGuaranteedHoldbackNumber(),
                'amount_guaranteed_holdback' => $invoice->getAmountGuaranteedHoldback(),
                'deposit_good_end_number' => $invoice->getDepositGoodEndNumber(),
                'amount_good_end' => $invoice->getAmountGoodEnd(),
                'invoiced_at' => $invoice->getInvoicedAt(),
            ];
        }

        return $data;
    }
}
