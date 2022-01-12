<div class="row">
    <div class="col-md-8">
        @attribute("{$contract_template_variable}|icon:tag|label:".__('addworking.contract.contract_template_variable._html.label'))
    </div>
    <div class="col-md-4">
        @attribute("{$contract_template_variable->id}|icon:id-card-alt|label:".__('addworking.contract.contract_template_variable._html.username'))
        @attribute("{$contract_template_variable->created_at}|icon:calendar-plus|label:".__('addworking.contract.contract_template_variable._html.created_date'))
        @attribute("{$contract_template_variable->updated_at}|icon:calendar-check|label:".__('addworking.contract.contract_template_variable._html.last_modified_date'))
    </div>
</div>
