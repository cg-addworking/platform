<table class="table table-borderless table-sm">
    <tbody>
        <tr>
            <td style="width: 55%">
                <table class="table table-borderless table-sm">
                    <tbody>
                        <tr>
                            <td><span class="font-weight-bold">{{ __('billing.outbound.application.views.file._summary.payment_deadline') }} : </span>{{ $outboundInvoice->getDueAt()->format('d/m/Y') ?? 'n/a' }}</td>
                        </tr>
                        <tr>
                            <td><span class="font-weight-bold">{{ __('billing.outbound.application.views.file._summary.iban_for_transfer') }} : </span>
                                @if($outboundInvoice->getDaillyAssignment())
                                    {{ __('billing.outbound.application.views.file._summary.line_1') }}
                                @else
                                    {{ ($param = $invoiceParameterRepository->findByEnterpriseSiret($outboundInvoice->getEnterprise()->identification_number)) ? ($param->getIban()->iban ?? "FR76 3000 3005 7100 0201 2497 429") : "FR76 3000 3005 7100 0201 2497 429" }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><span class="font-weight-bold">{{ __('billing.outbound.application.views.file._summary.referrence') }} : </span>{{ $outboundInvoice->getFormattedNumber() }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="table table-borderless table-sm">
                    <tbody>
                    @if (! empty($lines))
                        <tr>
                            <td class="text-right">{{ __('billing.outbound.application.views.file._summary.benifits') }}</td>
                            <td class="text-right">@money($outboundInvoiceFileRepository->getTotalLinesBeforeTaxes($outboundInvoice))</td>
                        </tr>
                    @endif
                    @if($feeRepository->getManagementFeesOfOutboundInvoiceBeforeTaxes($outboundInvoice) != 0)
                        <tr>
                            <td class="text-right">{{ __('billing.outbound.application.views.file._summary.management_fees_ht') }}</td>
                            <td class="text-right">@money($feeRepository->getManagementFeesOfOutboundInvoiceBeforeTaxes($outboundInvoice))</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="text-right table-active">{{ __('billing.outbound.application.views.file._summary.total_ht') }}</td>
                        <td class="text-right table-active">@money($outboundInvoice->getAmountBeforeTaxes())</td>
                    </tr>
                    <tr>
                        <td class="text-right">{{ __('billing.outbound.application.views.file._summary.total_vat') }}</td>
                        <td class="text-right">@money($outboundInvoice->getAmountOfTaxes())</td>
                    </tr>
                    @foreach($subTotalOfTaxes as $vatRate => $subTotalOfTaxe)
                            @if($subTotalOfTaxe > 0)
                                <tr>
                                    <td class="text-right" style="width: 50%">{{ __('billing.outbound.application.views.file._summary.vat_summary') }} {{$vatRateRepository->find($vatRate)->display_name}}</td>
                                    <td class="text-right">@money($subTotalOfTaxe)</td>
                                </tr>
                            @endif
                        @endforeach
                    <tr>
                        <td class="text-right font-weight-bold bg-bleu-addworking text-white" style="font-size: 14px !important;">{{ __('billing.outbound.application.views.file._summary.total_ttc') }}</td>
                        <td class="text-right font-weight-bold bg-bleu-addworking text-white" style="font-size: 14px !important;">@money($outboundInvoice->getAmountAllTaxesIncluded())</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>