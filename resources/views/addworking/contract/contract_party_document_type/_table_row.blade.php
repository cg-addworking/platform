<tr>
    <td>{{ $contract_party_document_type->documentType->views->link }}</td>
    <td>{{ Repository::contractPartyDocumentType()->getDocument($contract_party_document_type)->views->link }}</td>
    <td>@bool($contract_party_document_type->mandatory)</td>
    <td>@bool($contract_party_document_type->validation_required)</td>
    <td class="text-right">{{ $contract_party_document_type->views->actions }}</td>
</tr>
