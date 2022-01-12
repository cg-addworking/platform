<tr>
    <td>
        @include('sogetrel_passwork::acceptation._actions')
    </td>
    <td>{{$acceptation->getEnterprise()->views->link}}</td>
    <td>{{$acceptation->getAcceptedByName()}}</td>
    <td>@date($acceptation->getCreatedAt())</td>
    <td>{{$acceptation->getOperationalManagerName()}}</td>
    <td>{{$acceptation->getAdministrativeAssistantName()}}</td>
    <td>{{$acceptation->getAdministrativeManagerName()}}</td>
    <td>{{$acceptation->getContractSignatoryName()}}</td>
    <td>{{$acceptation->getNeedsDecennialInsurance()? 'Oui' : 'Non'}}</td>
    <td>{{$acceptation->getApplicablePriceSlip()}}</td>
    <td>
        @if ($acceptation->getBankGuaranteeAmount())
            @money($acceptation->getBankGuaranteeAmount())
        @else
            NC
        @endif
    </td>
    <td>@date($acceptation->getContractStartingAt())</td>
    <td>@date($acceptation->getContractEndingAt())</td>
    <td>{{short_string(optional($acceptation->getAcceptationComment())->content ?? 'N/A', 150)}}</td>
</tr>
