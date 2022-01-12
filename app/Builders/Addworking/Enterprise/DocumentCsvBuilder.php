<?php

namespace App\Builders\Addworking\Enterprise;

use Components\Infrastructure\Foundation\Application\CsvBuilder;
use Illuminate\Database\Eloquent\Model;

class DocumentCsvBuilder extends CsvBuilder
{
    protected $headers = [
        1  => 'UUID',
        2  => 'Date de depot',
        3  => "Date d'expiration",
        4  => 'Prestataire',
        5  => 'Type',
        6  => 'Statut',
        7  => 'Nature',
    ];

    protected function normalize(Model $model): array
    {
        return [
            1  => $model->id,
            2  => $model->created_at,
            3  => $model->valid_until,
            4  => $model->enterprise->name,
            5  => remove_accents($model->documentType->display_name ?? ''),
            6  => $model->status,
            7  => $model->documentType->type,
        ];
    }
}
