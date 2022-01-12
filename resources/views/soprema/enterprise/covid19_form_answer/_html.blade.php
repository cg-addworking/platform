<div class="row">
    <div class="col-md-8">
        @attribute("{$covid19_form_answer}|icon:tag|label:".__('soprema.enterprise.covid19_form_answer._html.label'))
    </div>
    <div class="col-md-4">
        @attribute("{$covid19_form_answer->id}|icon:id-card-alt|label:".__('soprema.enterprise.covid19_form_answer._html.username'))
        @attribute("{$covid19_form_answer->created_at}|icon:calendar-plus|label:".__('soprema.enterprise.covid19_form_answer._html.created_date'))
        @attribute("{$covid19_form_answer->updated_at}|icon:calendar-check|label:".__('soprema.enterprise.covid19_form_answer._html.last_modified_date'))
    </div>
</div>
