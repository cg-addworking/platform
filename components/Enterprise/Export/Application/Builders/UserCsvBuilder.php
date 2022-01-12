<?php

namespace Components\Enterprise\Export\Application\Builders;

use Components\Infrastructure\Foundation\Application\CsvBuilder;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Database\Eloquent\Model;

class UserCsvBuilder extends CsvBuilder
{
    protected $headers = [
        0  => "entreprise_id",
        1  => "raison_sociale",
        2  => "siret",
        3  => "numero_utilisateur",
        4  => "civilite",
        5  => "nom",
        6  => "prenom",
        7  => "mail",
        8  => "telephone",
        9  => "fonction",
        10 => "role",
        11 => "acces",
        12 => "actif",
        13 => "date_de_derniere_connexion",
        14 => "date_de_derniere_activite",
    ];

    public function append(Model $model): int
    {
        $result = true;

        foreach ($this->normalize($model) as $value) {
            $result &= parent::fputcsv($value);
        }
        
        return $result;
    }

    protected function normalize(Model $model): array
    {
        $content = [];

        foreach ($model->enterprises()->get() as $enterprise) {
            $content[] = [
                0  => $enterprise->id,
                1  => $enterprise->legalForm->display_name." - ".$enterprise->name,
                2  => $enterprise->identification_number,
                3  => $model->number,
                4  => $model->gender,
                5  => $model->lastname,
                6  => $model->firstname,
                7  => $model->email,
                8  => $this->getPhoneNumbers($model),
                9  => $model->getJobTitleFor($enterprise),
                10 => $this->getRoles($model, $enterprise),
                11 => $this->getPermissions($model, $enterprise),
                12 => $model->is_active ? "Oui": "Non",
                13 => $model->last_login,
                14 => $model->last_activity,
            ];
        }

        return $content;
    }

    private function getPhoneNumbers(User $model): string
    {
        return $model->phoneNumbers()->pluck('number')->join(' - ');
    }

    private function getRoles(User $user, Enterprise $model): string
    {
        $roles = $user->getRolesFor($model);

        return implode(" - ", $roles);
    }

    private function getPermissions(User $user, Enterprise $model): string
    {
        $permissions = $user->getAccessesFor($model);

        return implode(" - ", $permissions);
    }
}
