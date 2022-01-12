<!DOCTYPE HTML>
<HTML>
<HEAD>
    <META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
    <STYLE TYPE="text/css">
        <!--
        @page { margin-left: 0.25in; margin-right: 0.3in; margin-top: 0.3in; margin-bottom: 0.57in }
        @page:first { }
        P { margin-bottom: 0.08in; direction: ltr; widows: 2; orphans: 2 }
        -->
    </STYLE>
</HEAD>
<BODY LANG="fr-FR" DIR="LTR">
<P ALIGN=CENTER STYLE="margin-bottom: 0in; border: 1px solid #00000a; padding: 0.01in 0.06in"><FONT SIZE=4><B>QUESTIONNAIRE FOURNISSEUR&nbsp;SOGETREL</B></FONT></P>
<P STYLE="margin-bottom: 0in"><U><B>Coordonnées de l’entreprise </B></U></P>
<P STYLE="margin-bottom: 0in">Pays de l’entreprise : <FONT COLOR="#4472c4"><B>{{ strtoupper($vendor->country) ?? 'FRANCE' }}</B></FONT></P>
<P STYLE="margin-bottom: 0in">Nom de la société : <FONT COLOR="#4472c4"><B>{{ $vendor->name }}</B></FONT></P>
<P STYLE="margin-bottom: 0in">Adresse : <FONT COLOR="#4472c4"><B>{{ $vendor->address->address }}, {{ $vendor->address->additionnal_address ?? '' }}</B></FONT></P>
<P STYLE="margin-bottom: 0in">Code Postal : <FONT COLOR="#4472c4"><B>{{ $vendor->address->zipcode }}</B></FONT></P>
<P STYLE="margin-bottom: 0in">Ville : <FONT COLOR="#4472c4"><B>{{ $vendor->address->town }}</B></FONT></P>

<P STYLE="margin-bottom: 0in"><U><B>Identification de l’entreprise </B></U></P>
<P STYLE="margin-bottom: 0in">Activité : <FONT COLOR="#4472c4"><B>Prestations de service</B></FONT></P>
<P STYLE="margin-bottom: 0in">Code APE : <FONT COLOR="#4472c4"><B>{{ strtoupper($vendor->main_activity_code) ?? '' }}</B></FONT><FONT COLOR="#4472c4"></FONT></P>
<P STYLE="margin-bottom: 0in">Sous-Traitant : <FONT COLOR="#4472c4"><B>Oui</B></FONT></P>
<P STYLE="margin-bottom: 0in">Code SIRET : <FONT COLOR="#4472c4"><B>{{ $vendor->identification_number }}</B></FONT><B></B></P>
<P STYLE="margin-bottom: 0in">Organisation juridique :
    <FONT COLOR="#4472c4">
        <B>
            @switch($vendor->legalForm()->first()->name)
                @case('ei')
                @case('micro')
                @case('eirl')
                Personne physique
                @break

                @case('sas')
                @case('sasu')
                @case('sa')
                Société par actions
                @break

                @case('sarl')
                @case('sarlu')
                @case('eurl')
                Société de personne
                @break

                @default
                Autre
            @endswitch
        </B>
    </FONT>
</P>
<P STYLE="margin-bottom: 0in">N° TVA Intracommunautaire : <FONT COLOR="#4472c4"><B>{{ $tvaNumber }}</B></FONT></P>
<P STYLE="margin-bottom: 0in">Taux de TVA :
    <FONT COLOR="#4472c4">
        <B>
            @switch($vendor->legalForm()->first()->name)
                @case('ei')
                @case('micro')
                @case('eirl')
                0%
                @break

                @default
                20%
            @endswitch
        </B>
    </FONT>
</P>
<P STYLE="margin-bottom: 0in">Exigibilité de TVA :
    <FONT COLOR="#4472c4">
        <B>
            @switch($vendor->legalForm()->first()->name)
                @case('ei')
                @case('micro')
                @case('eirl')
                Exonéré
                @break

                @default
                Autoliquidé
            @endswitch
        </B>
    </FONT>
</P>
<P STYLE="margin-bottom: 0in">Code Taxe Sogetrel&nbsp;:
    <FONT COLOR="#4472c4">
        <B>
            @switch($vendor->legalForm()->first()->name)
                @case('ei')
                @case('micro')
                @case('eirl')
                FR_DE_DEC_EXO
                @break

                @default
                FR_DE_AUTOL_TN
            @endswitch
        </B>
    </FONT>
</P>

<P STYLE="margin-bottom: 0in"><U><B>Coordonnées commerciale de l’entreprise </B></U></P>
<P STYLE="margin-bottom: 0in">E-mail de commande :<FONT COLOR="#4472c4"><B>{{ $user->email }}</B></FONT></P>
<P STYLE="margin-bottom: 0in">E-mail d'envoi avis de paiement :<FONT COLOR="#4472c4"><B>facturation@addworking.com</B></FONT></P>
<P STYLE="margin-bottom: 0in">Téléphone &nbsp;:<FONT COLOR="#4472c4"><B>{{ $vendor->primary_phone_number }}</B></FONT></P>
<P STYLE="margin-bottom: 0in">Nom du commercial : <FONT COLOR="#4472c4"><B>{{ $user->name }}</B></FONT></P>
<P STYLE="margin-bottom: 0in">Adresse mail du commercial : <FONT COLOR="#4472c4"><B>{{ $user->email }}</B></FONT></P>
<P STYLE="margin-bottom: 0in"><U><B>Adresse de règlement</B></U></P>
<P STYLE="margin-bottom: 0in">Adresse&nbsp;: <FONT COLOR="#4472c4"><B>ADDWORKING - 17 RUE DU LAC SAINT ANDRE - SAVOIE TECHNOLAC - BP 350</B></FONT></P>
<P STYLE="margin-bottom: 0in">Code postal : <FONT COLOR="#4472c4"><B>73370</B></FONT><FONT COLOR="#4472c4"></FONT></P>
<P STYLE="margin-bottom: 0in">Ville&nbsp;: <FONT COLOR="#4472c4"><B>LE BOURGET DU LAC </B></FONT></P>
</BODY>
</HTML>