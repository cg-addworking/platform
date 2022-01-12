<div class="row">
    <div class="col-md-8">
        @attribute("{$contract_annex}|icon:tag|label:". __('addworking.contract.contract_annex._html.label'))
    </div>
    <div class="col-md-4">
        @attribute("{$contract_annex->id}|icon:id-card-alt|label:".__('addworking.contract.contract_annex._html.username'))
        @attribute("{$contract_annex->created_at}|icon:calendar-plus|label:". __('addworking.contract.contract_annex._html.created_date'))
        @attribute("{$contract_annex->updated_at}|icon:calendar-check|label:". __('addworking.contract.contract_annex._html.last_modified_date'))
    </div>
</div>
