<?php

namespace App\Models\TseExpressMedical\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\Mission\MissionTrackingLine;
use App\Repositories\Addworking\Mission\MilestoneRepository;
use App\Repositories\Addworking\Mission\MissionRepository;
use App\Repositories\Addworking\Mission\MissionTrackingLineRepository;
use App\Repositories\Addworking\Mission\MissionTrackingRepository;
use Carbon\Carbon;
use Components\Enterprise\AccountingExpense\Application\Repositories\EnterpriseRepository;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use stdClass;
use RuntimeException;

class MissionCsvLoader extends CsvLoader
{
    protected $flags = CsvLoader::IGNORE_FIRST_LINE | CsvLoader::VERBOSE;

    public function headers(): array
    {
        return [
            'nom',
            'adresse',
            'cp',
            'ville',
            'pays',
            'numcpt',
            'siret',
            'contrat_date_deb',
            'contrat_date_fin',
            'contrat_tarif',
            'contrat_location',
            'fact_date',
            'fact_nb_jour',
            'fact_montant',
            'fact_surcharge',
            'tournee',
        ];
    }

    public function cleanup(stdClass $item): stdClass
    {
        foreach ($this->headers() as $key) {
            $item->$key = ($str = trim($item->$key, " \t\n\r\x0B")) ? $str : null;

            if (strtolower($item->$key) == 'null') {
                $item->$key = null;
            }

            if ($key == 'fact_surcharge') {
                $item->$key = ($item->$key == "1") ? true : false;
            }
        }

        $item->contrat_tarif    = floatval(str_replace(',', '.', $item->contrat_tarif));
        $item->contrat_location = floatval(str_replace(',', '.', $item->contrat_location));
        $item->fact_montant     = floatval(str_replace(',', '.', $item->fact_montant));
        $item->fact_date        = Carbon::createFromFormat('Y-m-d', $item->fact_date)->endOfDay();
        $item->contrat_date_deb = Carbon::createFromFormat('Y-m-d', $item->contrat_date_deb)->startOfDay();

        if (!is_null($item->contrat_date_fin)) {
            $item->contrat_date_fin = Carbon::createFromFormat('Y-m-d', $item->contrat_date_fin)->startOfDay();
        }

        $rules = $this->getValidationRules();
        Validator::make((array) $item, $rules)->validate();

        return $item;
    }

    public function import(stdClass $item): bool
    {
        $vendor = $this->getEnterpriseFromCode($item->numcpt);

        if (!$vendor) {
            throw new RuntimeException("No vendor found for '{$item->numcpt}'");
        }

        $mission = $this->createMission($vendor, $item);
        $tracking = $this->createTracking($mission, $item);

        $this->createFirstTrackingLine($tracking, $item);
        $this->createRentalContractTrackingLine($tracking, $item);
        $this->createGasTaxTrackingLine($tracking, $item);

        return $mission->exists;
    }

    protected function getValidationRules(): array
    {
        return [
            'numcpt'           => "required|string",
            'contrat_date_deb' => "required|date",
            'contrat_tarif'    => "required|numeric",
            'contrat_location' => "required|numeric",
            'fact_date'        => "required|date",
            'fact_nb_jour'     => "required|numeric",
            'fact_montant'     => "required|numeric",
            'fact_surcharge'   => "required|boolean",
            'tournee'          => "required|string",
        ];
    }

    protected function createMission(Enterprise $vendor, stdClass $item): Mission
    {
        $customer = Enterprise::fromName('TSE EXPRESS MEDICAL');
        $mission = Mission::where('label', $item->tournee)->ofVendor($vendor)->ofCustomer($customer)->first();

        if (is_null($mission)) {
            $mission = app()->make(MissionRepository::class)->make([
                'label'          => $item->tournee,
                'status'         => Mission::STATUS_IN_PROGRESS,
                'unit'           => Mission::UNIT_DAYS,
                'starts_at'      => $item->contrat_date_deb,
                'ends_at'        => $item->contrat_date_fin,
                'milestone_type' => Milestone::MILESTONE_MONTHLY,
                'quantity'       => 0,
                'unit_price'     => 0,
                'external_id'    => $item->tournee,
            ]);

            $mission
                ->customer()->associate($customer)
                ->vendor()->associate($vendor)
                ->save();
        }

        $milestones = app()->make(MilestoneRepository::class)->createFromMission($mission);

        return $mission;
    }

    protected function createTracking(Mission $mission, stdClass $item): MissionTracking
    {
        $current_milestone = $mission->milestones()->where('ends_at', $item->fact_date)->first();

        $tracking = app()->make(MissionTrackingRepository::class)
            ->make([
                    'status' => MissionTracking::STATUS_PENDING,
                    'external_id' => $item->tournee,
                ]);
        $tracking->mission()->associate($mission);
        $tracking->milestone()->associate($current_milestone);
        $tracking->save();

        return $tracking;
    }

    protected function createFirstTrackingLine(MissionTracking $tracking, stdClass $item): MissionTrackingLine
    {
        $tracking_line = app()->make(MissionTrackingLineRepository::class)->make([
            'label'               => $item->tournee,
            'quantity'            => $item->fact_nb_jour,
            'unit_price'          => $item->contrat_tarif,
            'unit'                => Mission::UNIT_DAYS,
            'validation_customer' => MissionTrackingLine::STATUS_VALIDATED,
            'validation_vendor'   => MissionTrackingLine::STATUS_PENDING,
        ]);

        $tracking_line->missionTracking()->associate($tracking)->save();

        $default_accounting_expense = App::make(EnterpriseRepository::class)
            ->getByDefaultAccountingExpense($tracking->mission->customer);

        if (is_null($tracking_line->accountingExpense()->first()) && ! is_null($default_accounting_expense)) {
            $tracking_line->accountingExpense()->associate($default_accounting_expense)->save();
        }

        $tracking->update(['status' => MissionTracking::STATUS_SEARCH_FOR_AGREEMENT]);

        return $tracking_line;
    }

    protected function createRentalContractTrackingLine(MissionTracking $tracking, stdClass $item): ?MissionTrackingLine
    {
        if ($item->contrat_location <= 0) {
            return null;
        }

        $tracking_line = app()->make(MissionTrackingLineRepository::class)->make([
            'label'               => sprintf("%s - location", $item->tournee),
            'quantity'            => 1,
            'unit'                => Mission::UNIT_FIXED_FEES,
            'unit_price'          => - $item->contrat_location,
            'validation_customer' => MissionTrackingLine::STATUS_VALIDATED,
            'validation_vendor'   => MissionTrackingLine::STATUS_PENDING,
        ]);

        $tracking_line->missionTracking()->associate($tracking)->save();

        return $tracking_line;
    }

    protected function createGasTaxTrackingLine(MissionTracking $tracking, stdClass $item): ?MissionTrackingLine
    {
        if ($item->fact_surcharge != 1) {
            return null;
        }

        $tracking_line = app()->make(MissionTrackingLineRepository::class)->make([
            'label'               => sprintf("%s - taxe gasoil", $item->tournee),
            'quantity'            => 1,
            'unit'                => Mission::UNIT_FIXED_FEES,
            'unit_price'          => 0,
            'validation_customer' => MissionTrackingLine::STATUS_PENDING,
            'validation_vendor'   => MissionTrackingLine::STATUS_PENDING,
        ]);

        $tracking_line->missionTracking()->associate($tracking)->save();

        return $tracking_line;
    }

    protected function getEnterpriseFromCode($code): ?Enterprise
    {
        $enterprise = null;

        foreach (config('tse_express_medical.codes') as $id => $config) {
            if (array_get($config, 'code') == $code) {
                $enterprise = Enterprise::find($id);
            }
        }

        if (is_null($enterprise) && config('app.env') != 'production') {
            $enterprise = $this->createFakeVendorEnterprise();
        }

        return $enterprise;
    }

    protected function createFakeVendorEnterprise(): Enterprise
    {
        $vendor = factory(Enterprise::class)->state('vendor')->create();
        Enterprise::fromName('TSE EXPRESS MEDICAL')->vendors()->attach($vendor);

        return $vendor;
    }
}
