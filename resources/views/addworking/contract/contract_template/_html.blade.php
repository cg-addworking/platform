<div class="row">
    <div class="col-md-8">
        @attribute("{$contract_template->display_name}|icon:tag|label:".__('addworking.contract.contract_template._html.label'))
    </div>
    <div class="col-md-4">
        @attribute("{$contract_template->id}|icon:id-card-alt|label:".__('addworking.contract.contract_template._html.username'))
        @attribute("{$contract_template->created_at}|icon:calendar-plus|label:".__('addworking.contract.contract_template._html.created_date'))
        @attribute("{$contract_template->updated_at}|icon:calendar-check|label:".__('addworking.contract.contract_template._html.last_modified_date'))
        @attribute($contract_template->deleted_at ?? 'N/A'."|icon:calendar-check|label:".__('addworking.contract.contract_template._html.deleted_date'))
    </div>
</div>
