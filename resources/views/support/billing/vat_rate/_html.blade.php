<div class="row">
    <div class="col-md-8">
        @attribute("{$vat_rate->display_name}|icon:tag|label:Label")

        @component('bootstrap::attribute', ['icon' => "percent", 'label' => "Taux"])
            @percentage($vat_rate->value)
        @endcomponent

        @attribute("{$vat_rate->description}|icon:tag|label:Description")
    </div>
    <div class="col-md-4">
        @attribute("{$vat_rate->id}|icon:id-card-alt|label:Identifiant")
        @attribute("{$vat_rate->created_at}|icon:calendar-plus|label:Date de création")
        @attribute("{$vat_rate->updated_at}|icon:calendar-check|label:Date de dernière modification")
    </div>
</div>
