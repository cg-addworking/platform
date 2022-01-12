<?php

namespace App\Domain\SocieteGenerale\Billing;

use Carbon\Carbon;
use Exception;

class XmlGenerator
{
    public function generate($order, $invoices): string
    {
        if (count($invoices) == 0) {
            throw new Exception('Invoices collection empty');
        }

        foreach ($invoices as $invoice) {
            $monthFormat = str_replace('/', "", $invoice->outboundInvoice->month);
            $numberFormat = explode('_', $invoice->outboundInvoice->number()->first()->number);

            if (!$invoice->admin_amount_all_taxes_included) {
                throw new Exception("Amount all taxes included for {$invoice->id} is null");
            }

            if (!$invoice->enterprise->iban->iban) {
                throw new Exception("Iban for {$invoice->id} is null");
            }

            $creditTransferTransactionInformations[] = [
                'paymentIdentification' => [
                    'instructionIdentification' => substr($order->id."-".$invoice->number, 0, 35),
                    'endToEndIdentification' =>
                        substr("ADW-{$invoice->enterprise->number}-".
                            $monthFormat."-".$numberFormat[2]."-{$invoice->number}", 0, 35),
                ],
                'amount' => [
                    'instructedAmount' => ($invoice->admin_amount_all_taxes_included ?? 0),
                ],
                'creditorAgent' => [
                    'financialInstitutionIdentification' => [
                        'bic' => str_replace(' ', '', strtoupper($invoice->enterprise->iban->bic)),
                    ],
                ],
                'creditor' => [
                    'name' => substr($invoice->enterprise->name, 0, 70),
                ],
                'creditorAccount' => [
                    'identification' => [
                        'iban' => str_replace(' ', '', strtoupper($invoice->enterprise->iban->iban)),
                    ],
                ],
                'remittanceInformation' => [
                    'unstructured' => substr("ADDWORKING - {$invoice->outboundInvoice->enterprise}".
                        " - Missions-{$invoice->number}-{$invoice->outboundInvoice->month}", 0, 140),
                ]
            ];
        }

        $paymentInformation = [
            'paymentInformationIdentification' => substr("ADW-".Carbon::now()->format('YmdHis')."-".$order->id, 0, 35),
            'paymentMethod' => config('payment.method'),
            'paymentTypeInformation' => [
                'serviceLevel' => [
                    'code' => config('payment.type_code'),
                ],
            ],
            'requestedExecutionDate' => Carbon::now()->format('Y-m-d'),
            'debtor' => [
                'name' => substr(config('payment.debtor_name'), 0, 70),
            ],
            'debtorAccount' => [
                'identification' => [
                    'iban' => str_replace(' ', '', strtoupper(config('payment.debtor_iban'))),
                ],
            ],
            'debtorAgent' => [
                'financialInstitutionIdentification' => [
                    'bic' => str_replace(' ', '', strtoupper(config('payment.debtor_bic'))),
                ],
            ],
        ];

        $groupHeader = [
            'messageIdentification' => substr("ADDWORKING-missions-paiements", 0, 35),
            'creationDateTime' => Carbon::now()->format('Y-m-d\TH:i:s'),
            'numberOfTransactions' => count($creditTransferTransactionInformations),
            'controlSum' => collect($invoices)->sum('admin_amount_all_taxes_included'),
            'grouping' => config('payment.grouping'),
            'initiatingParty' => [
                'name' => substr(config('payment.debtor_name'), 0, 70),
            ],
        ];

        return view(
            'societe_generale.billing.sepa.xml',
            @compact('groupHeader', 'paymentInformation', 'creditTransferTransactionInformations')
        )->render();
    }
}
