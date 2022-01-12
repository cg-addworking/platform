<?php

namespace Components\Mission\TrackingLine\Application\Loaders;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\Mission\MissionTrackingLine;
use Carbon\Carbon;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use stdClass;
use RuntimeException;

class TrackingLineCsvLoader extends CsvLoader
{
    protected $flags = CsvLoader::IGNORE_FIRST_LINE | CsvLoader::VERBOSE;

    public function headers(): array
    {
        return [
            'nom_client',
            'siret_client',
            'nom_prestataire',
            'siret_prestataire',
            'identifiant_prestataire',
            'nom_mission',
            'date_operation',
            'libelle_operation',
            'quantite_operation',
            'prix_unitaire_operation',
            'unite_operation',
            'statut_client',
            'statut_prestataire'
        ];
    }

    public function cleanup(stdClass $item): stdClass
    {
        foreach ($this->headers() as $key) {
            $item->$key = ($str = trim($item->$key, " \t\n\r\x0B")) ? $str : null;

            if (strtolower($item->$key) == 'null') {
                $item->$key = null;
            }
        }

        $item->prix_unitaire_operation = floatval(str_replace(',', '.', $item->prix_unitaire_operation));
        $item->date_operation = Carbon::createFromFormat('Y-m-d', $item->date_operation)->startOfDay();

        $rules = $this->getValidationRules();
        Validator::make((array) $item, $rules)->validate();

        return $item;
    }

    protected function getValidationRules(): array
    {
        return [
            'nom_client' => 'nullable',
            'siret_client' => 'nullable',
            'nom_prestataire' => 'nullable',
            'siret_prestataire' => 'nullable',
            'identifiant_prestataire' => 'nullable',
            'nom_mission' => 'required',
            'date_operation' => 'required',
            'libelle_operation' => 'required',
            'quantite_operation' => 'required',
            'prix_unitaire_operation' => 'required',
            'unite_operation' => 'required',
            'statut_client' => 'nullable',
            'statut_prestataire' => 'nullable'
        ];
    }

    public function import(stdClass $item): bool
    {
        $customer = $this->findEnterpriseFrom($item->siret_client, $item->nom_client);

        $vendor = $this->findEnterpriseFrom(
            $item->siret_prestataire,
            $item->nom_prestataire,
            $customer,
            $item->identifiant_prestataire
        );

        $this->checkPartnership($customer, $vendor);

        $mission = $this->findOrCreateMission($item->nom_mission, $customer, $vendor, $item->date_operation);

        $milestone = $this->findOrCreateMilestone($mission, $item->date_operation->toDateString());

        $tracking = $this->findOrCreateTracking($mission, $milestone);

        $line = $this->createTrackingLine($tracking, $item);

        return $line->exists;
    }

    protected function findEnterpriseFrom(
        $identification_number,
        $name,
        $customer = null,
        $vendor_external_id = null
    ): Enterprise {
        $enterprise = null;

        switch (true) {
            case ! is_null($identification_number):
                $enterprise = Enterprise::query()
                    ->where('identification_number', $identification_number)
                    ->first();
                break;
            case ! is_null($customer) && ! is_null($vendor_external_id):
                $enterprise = $customer
                    ->vendors()
                    ->wherePivot('vendor_external_id', $vendor_external_id)
                    ->first();
                break;
            case ! is_null($name):
                $lowered_name = strtolower($name);
                $enterprise = Enterprise::query()
                    ->where(DB::raw("LOWER(CAST(name as TEXT))"), 'LIKE', "%{$lowered_name}%")
                    ->first();
                break;
            default:
                throw new RuntimeException("data is mission to find the enterprise");
        }

        if (is_null($enterprise)) {
            throw new RuntimeException("No enterprise found for '{$identification_number}'");
        }

        return $enterprise;
    }

    protected function checkPartnership(Enterprise $customer, Enterprise $vendor): void
    {
        if (! $customer->isCustomer()) {
            throw new RuntimeException("{$customer->name} is not a customer");
        }

        if (! $vendor->isVendor()) {
            throw new RuntimeException("{$vendor->name} is not a vendor");
        }

        if (! $vendor->isVendorOf($customer)) {
            throw new RuntimeException("{$vendor->name} is not a vendor of {$customer->name}");
        }
    }

    protected function findOrCreateMission(
        string $label,
        Enterprise $customer,
        Enterprise $vendor,
        DateTime $starts_at
    ): Mission {
        $mission = Mission::query()
            ->where('label', $label)
            ->whereHas('customer', function ($query) use ($customer) {
                $query->where('id', $customer->id);
            })
            ->whereHas('vendor', function ($query) use ($vendor) {
                $query->where('id', $vendor->id);
            })
            ->latest()
            ->first();

        if (is_null($mission)) {
            $mission = new Mission;

            $mission->label = $label;
            $mission->starts_at = $starts_at;
            $mission->status = Mission::STATUS_IN_PROGRESS;
            $mission->milestone_type = Milestone::MILESTONE_MONTHLY;
            $mission->vendor()->associate($vendor);
            $mission->customer()->associate($customer);

            $mission->save();

            $mission->refresh();
        }

        return $mission;
    }

    protected function findOrCreateMilestone(Mission $mission, string $date): Milestone
    {
        $from = Carbon::createFromFormat('Y-m-d', $date)->startOfMonth();
        $to = Carbon::createFromFormat('Y-m-d', $date)->endOfMonth();

        $milestone = Milestone::query()
            ->whereHas('mission', function ($query) use ($mission) {
                $query->where('id', $mission->id);
            })
            ->where('starts_at', '>=', $from->format('Y-m-d'))
            ->where('ends_at', '<=', $to->format('Y-m-d'))
            ->first();

        if (is_null($milestone)) {
            $milestone = new Milestone;

            $milestone->starts_at = $from;
            $milestone->ends_at = $to;
            $milestone->mission()->associate($mission);

            $milestone->save();

            $milestone->refresh();
        }

        return $milestone;
    }

    protected function findOrCreateTracking(Mission $mission, Milestone $milestone): MissionTracking
    {
        $tracking = MissionTracking::query()
            ->whereHas('mission', function ($query) use ($mission) {
                $query->where('id', $mission->id);
            })
            ->whereHas('milestone', function ($query) use ($milestone, $mission) {
                $query
                    ->where('starts_at', '>=', $milestone->starts_at)
                    ->where('ends_at', '<=', $milestone->ends_at);
            })
            ->first();

        if (is_null($tracking)) {
            $tracking = new MissionTracking;

            $tracking->status = MissionTracking::STATUS_PENDING;
            $tracking->mission()->associate($mission);
            $tracking->milestone()->associate($milestone);
            $tracking->save();
            $tracking->refresh();
        }

        return $tracking;
    }

    protected function createTrackingLine(MissionTracking $tracking, StdClass $item): MissionTrackingLine
    {
        $line = new MissionTrackingLine;

        $line->label = $item->libelle_operation;
        $line->quantity = $item->quantite_operation;
        $line->unit = $this->getUnitFromTranslation($item->unite_operation);
        $line->unit_price = $item->prix_unitaire_operation;
        $line->validation_vendor = $item->statut_prestataire ?? MissionTrackingLine::STATUS_PENDING;
        $line->validation_customer = $item->statut_client ?? MissionTrackingLine::STATUS_VALIDATED;
        $line->missionTracking()->associate($tracking);

        $line->save();

        $line->refresh();

        return $line;
    }

    protected function getUnitFromTranslation($unit): string
    {
        $translated_units  = [
            strtoupper(__('mission.mission.unit_hours')) => Mission::UNIT_HOURS,
            strtoupper(__('mission.mission.unit_days')) => Mission::UNIT_DAYS,
            strtoupper(__('mission.mission.unit_fixed_fees')) => Mission::UNIT_FIXED_FEES,
            strtoupper(__('mission.mission.unit')) => Mission::UNIT_UNIT,
        ];

        return $translated_units[strtoupper($unit)];
    }
}
