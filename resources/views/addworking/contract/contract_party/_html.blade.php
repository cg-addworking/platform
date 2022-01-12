<div class="row">
    <div class="col-md-8">
        @attribute("{$contract_party}|icon:tag|label:".__('addworking.contract.contract_party._html.label'))
    </div>
    <div class="col-md-4">
        @attribute("{$contract_party->id}|icon:id-card-alt|label:".__('addworking.contract.contract_party._html.username'))
        @attribute("{$contract_party->created_at}|icon:calendar-plus|label:".__('addworking.contract.contract_party._html.created_date'))
        @attribute("{$contract_party->updated_at}|icon:calendar-check|label:".__('addworking.contract.contract_party._html.last_modified_date'))
    </div>
</div>
