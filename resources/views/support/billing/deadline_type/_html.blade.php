<div class="row">
    <div class="col-md-8">
        @attribute("{$deadline_type->display_name}|icon:tag|label:Label")
        @attribute("{$deadline_type->value}|icon:calendar-alt|label:Jours")
        @attribute("{$deadline_type->description}|icon:tag|label:Description")
    </div>
    <div class="col-md-4">
        @attribute("{$deadline_type->id}|icon:id-card-alt|label:Identifiant")
        @attribute("{$deadline_type->created_at}|icon:calendar-plus|label:Date de création")
        @attribute("{$deadline_type->updated_at}|icon:calendar-check|label:Date de dernière modification")
    </div>
</div>
