<tr>
    <td>{{ $contract_template_party_document_type->documentType->display_name }}</td>
    <td class="text-center">@bool($contract_template_party_document_type->mandatory)</td>
    <td class="text-center">@bool($contract_template_party_document_type->validation_required)</td>
    <td>{{ $contract_template_party_document_type->validatedBy->denomination}}</td>
    <td class="text-right">{{ $contract_template_party_document_type->views->actions }}</td>
</tr>
