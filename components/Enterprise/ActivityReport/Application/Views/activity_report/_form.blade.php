@inject('enterpriseRepository', 'App\Repositories\Addworking\Enterprise\EnterpriseRepository')

<legend class="h5">Avez-vous déjà travaillé pour SOGETREL au cours du mois de {{__('components.enterprise.activity_report.application.views.activity_report.months.'. $month_name)}} {{$year}}</legend>
Si oui, merci d'indiquer sur quelle(s) zone(s) et sur quel(s) contrat(s) :<br/><br/>
@foreach($activity_report->vendor->customers as $customer)
    <ul class="list-group pb-3">
        @form_control([
            'class' => "font-weight-bold",
            'text'  => $customer->name,
            'type'  => "checkbox",
            'name'  => "activity_report[customers][]",
            'value' => $customer->id
        ])
        @foreach($enterpriseRepository->getMissions($customer, $activity_report->vendor) as $mission)
            <li class="list-group-item">
                @form_control([
                    'text'  => $mission->label,
                    'type'  => "checkbox",
                    'name'  => "activity_report[missions][]",
                    'value' => $mission->id,
                ])
            </li>
        @endforeach
    </ul>
@endforeach

@form_control([
    'class' => "pb-2 font-weight-bold",
    'text'  => 'Autre',
    'type'  => "checkbox",
    'name'  => "activity_report.other_activity_checkbox",
])

@form_control([
    'class' => "mt-n2 col-md-3",
    'type'  => "text",
    'name'  => "activity_report.other_activity",
    'placeholder' => "précisez",
])

<div class="pt-5">
    @form_control([
        'class' => "font-weight-bold",
        'text'  => "Je n'ai pas travaillé sur le mois en cours",
        'type'  => "checkbox",
        'name'  => "activity_report.no_activity",
    ])
</div>

@form_group([
    'class'       => 'ml-n2 pt-3 col-md-8',
    'text'        => __('components.enterprise.activity_report.application.views.activity_report._form.note'),
    'type'        => "textarea",
    'name'        => "activity_report.note",
    'value'       => optional($activity_report)->getNote(),
    'placeholder' => "Ajouter ici toute précision éventuelle sur vos missions du mois en cours",
    'rows'        => 6
])

<input type="hidden" name="activity_report[month]" value="{{$month}}">
<input type="hidden" name="activity_report[year]" value="{{$year}}">
