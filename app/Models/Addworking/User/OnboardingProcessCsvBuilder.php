<?php

namespace App\Models\Addworking\User;

use Components\Infrastructure\Foundation\Application\CsvBuilder;
use App\Models\Addworking\User\OnboardingProcess;
use Illuminate\Database\Eloquent\Model;

class OnboardingProcessCsvBuilder extends CsvBuilder
{
    protected $headers = [
        1 => 'Utilisateur',
        2 => 'Email',
        3 => 'Entreprise',
        4 => 'Client',
        5 => 'Domaine concerné',
        6 => 'Date de création',
        7 => 'Statut',
        8 => 'Etape en cours',
    ];

    protected function normalize(Model $model): array
    {
        return [
            1 =>  $model->user->name,
            2 =>  $model->user->email,
            3 =>  $model->user->enterprise->name ? remove_accents($model->user->enterprise->name) : '',
            4 =>  $this->getCustomerNames($model),
            5 =>  $model->enterprise->name,
            6 =>  $model->created_at,
            7 =>  $model->complete ? "Termine" : "En cours",
            8 =>  $model->getCurrentStep()->getDisplayName(),
        ];
    }

    protected function getCustomerNames(OnboardingProcess $model)
    {
        $customerNames = [];

        foreach ($model->user->enterprise->customers as $customer) {
            $customerNames[] = remove_accents($customer->name);
        }

        return !empty($customerNames) ? implode('; ', $customerNames) : '';
    }
}
