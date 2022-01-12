@inject('captureInvoiceRepository', 'Components\Contract\Contract\Application\Repositories\CaptureInvoiceRepository')
@inject('accountingMonitoringRepository', 'Components\Contract\Contract\Application\Repositories\AccountingMonitoringRepository')
@inject('subcontractingDeclarationRepository', 'Components\Contract\Contract\Application\Repositories\SubcontractingDeclarationRepository')

<tr>
    <td>
        @can('create', get_class($captureInvoiceRepository->make()))
            <a href="{{route('contract.capture_invoice.create', $contract->getId())}}" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="Imputer une facture">
                @icon('plus')
            </a>
            @if (count($captureInvoiceRepository->getCaptureInvoices($contract->getId())))
                <a href="{{route('contract.capture_invoice.index', $contract->getId())}}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Voir les factures imputées">
                    @icon('bars')
                </a>
            @endcan
        @endcan
    </td>
    <td>
        <a href="{{ route('contract.show', $contract) }}">{{$contract->getNumber()}}</a>
    </td>
    <td>
        {{$accountingMonitoringRepository->getWorkfieldName($contract)}}
    </td>
    <td>{{$accountingMonitoringRepository->getVendor($contract)}}</td>
    <td>
        @if(is_null($accountingMonitoringRepository->getSignature($contract)))
            n/a
        @else
            @date($accountingMonitoringRepository->getSignature($contract))
        @endif
    </td>
    <td>{{$accountingMonitoringRepository->getPayment($contract)}}</td>
    <td>
        @if($declaration = $subcontractingDeclarationRepository->getSubcontractingDeclarationOf($contract))
            @date($declaration->getValidationDate())
            <br>
            {{$declaration->getPercentOfAggregation()}} %
            @if(!is_null($contract->getSubcontractingDeclaration()->getFile()))
                <a href="{{ route('file.download', $contract->getSubcontractingDeclaration()->getFile()) }}">@icon('download')</a>
            @endif
        @else
            n/a
        @endif
    </td>
    <td>@money($accountingMonitoringRepository->getAmountBeforeTaxes($contract))</td>
    <td>@money($accountingMonitoringRepository->getAmountBeforeTaxesInvoiced($contract))</td>
    <td>@money($accountingMonitoringRepository->getAmountOfTaxesInvoiced($contract))</td>
    <td>@money($accountingMonitoringRepository->getAmountOfRemainsToBeBilled($contract))</td>
    <td>{{$accountingMonitoringRepository->getGuaranteedHoldback($contract)}}</td>
    <td>@money($accountingMonitoringRepository->getGuaranteedHoldbackAmount($contract))</td>
    <td>{{$accountingMonitoringRepository->getGuaranteedHoldbackDepositNumber($contract)}}</td>
    <td>{{$accountingMonitoringRepository->getGoodEnd($contract)}}</td>
    <td>@money($accountingMonitoringRepository->getGoodEndAmount($contract))</td>
    <td>{{$accountingMonitoringRepository->getGoodEndDeposit($contract)}}</td>
</tr>
