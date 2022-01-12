<div class="row">
    <div class="col-md-8">
        @attribute("{$legal_form->display_name}|icon:tag|label:".__('addworking.enterprise.legal_form._html.wording'))
        @attribute("{$legal_form->name}|icon:tag|label:".__('addworking.enterprise.legal_form._html.acronym'))
        @attribute("{$legal_form->country}|icon:tag|label:Pays")
    </div>
    <div class="col-md-4">
        @attribute("{$legal_form->id}|icon:id-card-alt|label:".__('addworking.enterprise.legal_form._html.username'))
        @attribute("{$legal_form->created_at}|icon:calendar-plus|label:".__('addworking.enterprise.legal_form._html.creation_date'))
        @attribute("{$legal_form->updated_at}|icon:calendar-check|label:".__('addworking.enterprise.legal_form._html.last_modification_date'))
    </div>
</div>
