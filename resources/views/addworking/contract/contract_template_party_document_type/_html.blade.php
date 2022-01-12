<div class="row">
    <div class="col-md-8">
        @attribute("{$contract_template_party_document_type->documentType->display_name}|icon:tag|label:".__('addworking.contract.contract_template_party_document_type._html.label'))
    </div>
    <div class="col-md-4">
        @attribute("{$contract_template_party_document_type->id}|icon:id-card-alt|label:".__('addworking.contract.contract_template_party_document_type._html.username'))
        @attribute("{$contract_template_party_document_type->created_at}|icon:calendar-plus|label:".__('addworking.contract.contract_template_party_document_type._html.created_date'))
        @attribute("{$contract_template_party_document_type->updated_at}|icon:calendar-check|label:".__('addworking.contract.contract_template_party_document_type._html.last_modified_date'))
    </div>
</div>
