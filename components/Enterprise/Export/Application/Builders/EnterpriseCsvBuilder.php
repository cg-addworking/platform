<?php

namespace Components\Enterprise\Export\Application\Builders;

use Components\Infrastructure\Foundation\Application\CsvBuilder;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Database\Eloquent\Model;

class EnterpriseCsvBuilder extends CsvBuilder
{
    protected $headers = [
        0  => "entreprise_id",
        1  => "raison_sociale",
        2  => "siret",
        3  => "numero_entreprise",
        4  => "type_vendor",
        5  => "type_client",
        6  => "forme_legale",
        7  => "adresse",
        8  => "telephone",
        9  => "kbis_transmis",
        10 => "date_de_creation_dans_addworking",
        11 => "date_de_derniere_modification_dans_addworking",
        12 => "activites",
        13 => "secteur_d_activites",
        14 => "nombre_d_employes",
        15 => "code_ape",
    ];

    protected function normalize(Model $model): array
    {
        return [
            0  => $model->id,
            1  => $model->legalForm->display_name." - ".$model->name,
            2  => $model->identification_number,
            3  => $model->number,
            4  => $model->is_vendor ? "Oui" : "Non",
            5  => $model->is_customer ? "Oui" : "Non",
            6  => $model->legalForm->display_name,
            7  => $this->getAddresses($model),
            8  => $this->getPhoneNumbers($model),
            9  => $this->hasKbisDocument($model) ? "Oui" : "Non",
            10 => $model->created_at,
            11 => $model->updated_at,
            12 => $this->getActivities($model),
            13 => $this->getActivityFields($model),
            14 => $model->getEmployeesCount(),
            15 => $model->main_activity_code,
        ];
    }

    private function getAddresses(Enterprise $model): string
    {
        return $model->addresses->pluck('oneLine')->join(' - ');
    }

    private function getPhoneNumbers(Enterprise $model): string
    {
        return $model->phoneNumbers()->pluck('number')->join(' - ');
    }

    private function hasKbisDocument(Enterprise $model): bool
    {
        return Document::whereHas('enterprise', fn($q) => $q->whereId($model->id))
        ->whereHas('documentType', function ($query) {
            return $query->where('name', "certificate_of_establishment");
        })->exists();
    }

    private function getActivities(Enterprise $model): string
    {
        return $model->activities()->pluck('activity')->join(' - ');
    }

    private function getActivityFields(Enterprise $model): string
    {
        return $model->activities()->pluck('field')->join(' - ');
    }
}
