<b>Commentaire / Précision sur le contrat :</b><br>
@if(is_null($acceptation->getAcceptationComment()))
    N/A
@else
    {!! $acceptation->getAcceptationComment()->content_html !!}
@endif
<hr/>
<b>Suivi Opérationnel :</b><br/>
{!! $acceptation->getOperationalMonitoringDataComment()->content_html !!}
