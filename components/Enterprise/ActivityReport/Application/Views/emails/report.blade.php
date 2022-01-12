@component('mail::message')
Bonjour,

Veuillez trouver ci-joint le rapport d'activité pour {{strtolower(Carbon\Carbon::now()->subMonth()->format('F Y'))}}

Cordialement

L’équipe AddWorking

@endcomponent
