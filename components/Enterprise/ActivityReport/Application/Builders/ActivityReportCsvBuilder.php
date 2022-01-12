<?php

namespace Components\Enterprise\ActivityReport\Application\Builders;

use Components\Infrastructure\Foundation\Application\CsvBuilder;
use Components\Enterprise\ActivityReport\Application\Repositories\ActivityReportRepository;
use Illuminate\Database\Eloquent\Model;

class ActivityReportCsvBuilder extends CsvBuilder
{
    protected $headers = [
        0 => "Entreprise du repondant",
        1 => "Nom du repondant",
        2 => "Periode",
        3 => "client concerne",
        4 => "Mission concernee",
        5 => "date heure de la reponse",
        6 => "note",
        7 => "Actif",
        8 => "Autre travaux",
    ];

    protected $customers;
    protected array $content;

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
        if ($model->no_activity ||
            (!$model->activityReportCustomers()->exists() &&
                !$model->activityReportMissions()->exists()
            )
        ) {
            return $this->noActivityContent($model);
        }

        $this->content = [];

        $this->missionsContent($model);

        $this->customerWithoutMissionsContent($model);

        return $this->content;
    }

    private function noActivityContent($model)
    {
        $this->content = [];

        $this->content[] = [
            0 => $model->vendor->name,
            1 => $model->createdBy->name,
            2 => $model->year . '-'. $model->month ,
            3 => 'n/a',
            4 => 'n/a',
            5 => $model->created_at,
            6 => $model->note,
            7 => $model->no_activity ? 'non' : 'oui',
            8 => 'n/a',
        ];

        return $this->content;
    }

    private function missionsContent($model)
    {
        $this->customers = app(ActivityReportRepository::class)->getCustomers($model);

        foreach ($model->activityReportMissions as $activityReportMission) {
            $this->customers->push($activityReportMission->mission->customer);

            $this->content[] = [
                0 => $model->vendor->name,
                1 => $model->createdBy->name,
                2 => $model->year . '-'. $model->month ,
                3 => $activityReportMission->mission->customer->name,
                4 => $activityReportMission->mission->label,
                5 => $model->created_at,
                6 => $model->note,
                7 => $model->no_activity ? 'non' : 'oui',
                8 => $model->other_activity,
            ];
        }

        return $this->content;
    }

    private function customerWithoutMissionsContent($model)
    {
        foreach ($this->customers->unique() as $customer) {
            $this->content[] = [
                0 => $model->vendor->name,
                1 => $model->createdBy->name,
                2 => $model->year . '-'. $model->month ,
                3 => $customer->name,
                4 => 'n/a',
                5 => $model->created_at,
                6 => $model->note,
                7 => $model->no_activity ? 'non' : 'oui',
                8 => $model->other_activity,
            ];
        }

        return $this->content;
    }
}
