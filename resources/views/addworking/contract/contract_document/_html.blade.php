<div class="row">
    <div class="col-md-8">
        @attribute("{$contract_document}|icon:tag|label:".__('addworking.contract.contract_document._html.label'))
    </div>
    <div class="col-md-4">
        @attribute("{$contract_document->id}|icon:id-card-alt|label:".__('addworking.contract.contract_document._html.username'))
        @attribute("{$contract_document->created_at}|icon:calendar-plus|label:".__('addworking.contract.contract_document._html.created_date'))
        @attribute("{$contract_document->updated_at}|icon:calendar-check|label:".__('addworking.contract.contract_document._html.last_modified_date'))
    </div>
</div>
