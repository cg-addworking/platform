<?php

namespace App\Domain\Sogetrel;

use Components\Infrastructure\Foundation\Application\CsvBuilder;
use Illuminate\Database\Eloquent\Model;

class UserLogCsvBuilder extends CsvBuilder
{
    /**
     * Headers
     *
     * var array
     */
    protected $headers = [
        0  => "Date de Création",
        1  => "Date de Mise à jour",
        2  => "Entreprise",
        3  => "Prénom",
        4  => "Nom",
        5  => "Adresse IP",
        6  => "Méthode HTTP",
        7  => "Route",
        8  => "Url",
    ];

    /**
     * Get the array representation for the given model
     *
     * param  \Illuminate\Database\Eloquent\Model  $model
     * return array
     */
    protected function normalize(Model $userlog): array
    {
        return [
            0  => $userlog->created_at,
            1  => $userlog->updated_at,
            2  => $userlog->user->enterprise->name,
            3  => $userlog->user->firstname,
            4  => $userlog->user->lastname,
            5  => $userlog->ip,
            6  => $userlog->http_method,
            7  => $userlog->route,
            8  => $userlog->url,
        ];
    }
}
