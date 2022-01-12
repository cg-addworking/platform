<?php

namespace Components\Connector\Airtable\Application\Commands;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\Mission\MissionTrackingLine;
use Carbon\Carbon;
use Components\Connector\Airtable\Application\Client as Airtable;
use Components\Enterprise\AccountingExpense\Application\Repositories\EnterpriseRepository;
use Components\Sogetrel\Mission\Application\Models\MissionTrackingLineAttachment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class CreateSogetrelAttachmentCommand extends Command
{
    protected $signature = 'sogetrel:create-attachments-from-airtable';

    protected $description = 'Create Sogetrel attachments from airtable';

    const TABLE = 'tblinElmDmyS4Cp5V';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (! env('AIRTABLE_SOGETREL_ATTACHMENT_ENABLED')) {
            $this->error('Airtable: command disabled');
            return;
        }

        if (env('APP_ENV') != 'production') {
            $this->error('Airtable: env is not production');
            return;
        }

        $query = "view=4+-+A+integrer+dans+APP+(auto)&fields%5B%5D=DOCUSIGN_VENDOR_sign";
        $query .= "&fields%5B%5D=MISSION_periode&fields%5B%5D=MISSION+Name+(from+MISSION_name)";
        $query .= "&fields%5B%5D=CLIENT_uuid+(from+CLIENT_name+(linked))&fields%5B%5D=nom_prestataire";
        $query .= "&fields%5B%5D=CLIENT_name+(from+CLIENT_name+(linked))&fields%5B%5D=uid_prestataire";
        $query .= "&fields%5B%5D=uuid_prestataire+(from+VENDOR_num_ORACLE)";
        $query .= "&fields%5B%5D=ATTACHEMENT_num&fields%5B%5D=AUTOLIQUIDATION&fields%5B%5D=CMD_num";
        $query .= "&fields%5B%5D=MONTANT_HT&fields%5B%5D=MONTANT_TVA&fields%5B%5D=MONTANT_TTC&fields%5B%5D=Status";

        $client = new Airtable;
        $attachments = $client->getRecords(self::TABLE, $query);

        foreach ($attachments->body->records as $record) {
            $fields = $record->fields;

            if ($fields->Status !== '4 - A integrer dans APP') {
                continue;
            }

            if (isset($fields->StandBy)) {
                continue;
            }

            if (isset($fields->{"CLIENT_uuid (from CLIENT_name (linked))"})) {
                $client_uuid = trim($fields->{"CLIENT_uuid (from CLIENT_name (linked))"}[0]);
                $customer = Enterprise::where('id', $client_uuid)->where('is_customer', true)->first();
            } else {
                $msg_error = "Airtable: missing attribute [CLIENT_uuid] to identify customer (ERR02)";
                $this->warn($msg_error);
                Log::warning($msg_error);
                $this->sendErrorToAirtable($client, $record->id, $msg_error);
                continue;
            }

            if (! isset($customer)) {
                $msg_error = "Airtable: customer {$client_uuid} not found in database (ERR03)";
                $this->warn($msg_error);
                Log::warning($msg_error);
                $this->sendErrorToAirtable($client, $record->id, $msg_error);
                continue;
            }

            if (! $this->isSogetrelGroup($customer)) {
                $msg_error = "Airtable: {$customer->name} is not a Sogetrel Group enterprise (ERR04)";
                $this->warn($msg_error);
                Log::warning($msg_error);
                $this->sendErrorToAirtable($client, $record->id, $msg_error);
                continue;
            }

            if (isset($fields->{"uuid_prestataire (from VENDOR_num_ORACLE)"})) {
                $vendor_uuid = trim($fields->{"uuid_prestataire (from VENDOR_num_ORACLE)"}[0]);
                $vendor = Enterprise::where('id', $vendor_uuid)->where('is_vendor', true)->first();
            } else {
                $msg_error = "Airtable: missing attribute [uuid_prestataire (from VEND ...] to identify vendor (ERR05)";
                $this->warn($msg_error);
                Log::warning($msg_error);
                $this->sendErrorToAirtable($client, $record->id, $msg_error);
                continue;
            }

            if (! isset($vendor)) {
                $msg_error = "Airtable: vendor {$vendor_uuid} not exist in database (ERR06)";
                $this->warn($msg_error);
                Log::warning($msg_error);
                $this->sendErrorToAirtable($client, $record->id, $msg_error);
                continue;
            }

            if (! $this->isVendorWith($vendor, $customer)) {
                $msg_error = "Airtable: {$vendor->name} ({$vendor->id}) is not a vendor of {$customer->name} (ERR07)";
                $this->warn($msg_error);
                Log::warning($msg_error);
                $this->sendErrorToAirtable($client, $record->id, $msg_error);
                continue;
            }

            if (! isset($fields->ATTACHEMENT_num)) {
                $msg_error = "Airtable: missing attribute [ATTACHEMENT_num] to identify attachment (ERR08)";
                $this->warn($msg_error);
                Log::warning($msg_error);
                $this->sendErrorToAirtable($client, $record->id, $msg_error);
                continue;
            }

            if (! isset($fields->DOCUSIGN_VENDOR_sign)) {
                $msg_error = "Airtable: missing attribute [DOCUSIGN_VENDOR_sign] to identify vendor sign date (ERR10)";
                $this->warn($msg_error);
                Log::warning($msg_error);
                $this->sendErrorToAirtable($client, $record->id, $msg_error);
                continue;
            }

            $attachment_number = trim($fields->ATTACHEMENT_num);
            $command_number = trim($fields->CMD_num);

            $mtla = MissionTrackingLineAttachment::where('num_attachment', $attachment_number)
                ->where('num_order', $command_number)->first();

            if (! is_null($mtla)) {
                $msg_error = "Airtable: {$attachment_number} attachment already exist in database (ERR11)";
                $this->warn($msg_error);
                Log::warning($msg_error);
                $this->sendErrorToAirtable($client, $record->id, $msg_error);
                continue;
            }

            $mission = $this->findOrCreateMission(
                trim($fields->{'MISSION Name (from MISSION_name)'}[0]),
                $fields->MISSION_periode,
                $vendor,
                $customer
            );

            $milestone = $this->findOrCreateMilestone($mission, $fields->MISSION_periode);

            $trackingLine = $this->findOrCreateTracking(
                $mission,
                $milestone,
                $attachment_number,
                $command_number,
                $fields->MONTANT_HT
            );

            $attachment = new MissionTrackingLineAttachment;
            $attachment->num_order = $command_number;
            $attachment->num_attachment = $attachment_number;
            $attachment->signed_at = $fields->DOCUSIGN_VENDOR_sign;
            $attachment->reverse_charges = (isset($fields->AUTOLIQUIDATION) ? true : false);
            $attachment->amount = $fields->MONTANT_TTC;
            $attachment->created_from_airtable = true;
            $attachment->missionTrackingLine()->associate($trackingLine);

            if ($attachment->save()) {
                $client->updateRecord(self::TABLE, [
                    'records' => [
                        [
                            'id' => $record->id,
                            'fields' => [
                                'APP_date_enregistrement' => Carbon::now()->format('Y-m-d'),
                            ]
                        ]
                    ]
                ]);

                $this->info("Airtable: attachment {$attachment_number} successfuly added to platform");
            }
        }

        $this->info("Task finished");
    }

    private function isSogetrelGroup(Enterprise $enterprise): bool
    {
        return $enterprise->name === 'SOGETREL'
            || $enterprise->parent->exists && $this->isSogetrelGroup($enterprise->parent);
    }

    private function isVendorWith(Enterprise $vendor, Enterprise $customer): bool
    {
        return $vendor->customers()->get()->contains($customer);
    }

    private function findOrCreateMission(string $label, string $starts_at, Enterprise $vendor, Enterprise $customer)
    {
        $mission = Mission::where('label', $label)->whereHas('vendor', function ($query) use ($vendor) {
            $query->where('id', $vendor->id);
        })->whereHas('customer', function ($query) use ($customer) {
            $query->where('id', $customer->id);
        })->latest()->first();

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

    private function findOrCreateMilestone(Mission $mission, string $date)
    {
        $from = Carbon::createFromFormat('d/m/Y', $date)->startOfMonth();
        $to = Carbon::createFromFormat('d/m/Y', $date)->endOfMonth();

        $milestone = Milestone::whereHas('mission', function ($query) use ($mission) {
            $query->where('id', $mission->id);
        })->where('starts_at', '>=', $from->format('Y-m-d'))
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

    private function findOrCreateTracking(
        Mission $mission,
        Milestone $milestone,
        string $numAttachment,
        string $numOrder,
        float $amountBeforeTaxes
    ) {
        $tracking = new MissionTracking;
        $tracking->status = MissionTracking::STATUS_VALIDATED;
        $tracking->mission()->associate($mission);
        $tracking->milestone()->associate($milestone);
        $tracking->save();
        $tracking->refresh();

        $line = new MissionTrackingLine;
        $line->missionTracking()->associate($tracking);
        $line->label = $numOrder . " - " . $numAttachment;
        $line->quantity = 1;
        $line->unit = Mission::UNIT_FIXED_FEES;
        $line->unit_price = $amountBeforeTaxes;
        $line->validation_vendor = MissionTrackingLine::STATUS_VALIDATED;
        $line->validation_customer = MissionTrackingLine::STATUS_VALIDATED;
        $line->save();

        $default_accounting_expense = App::make(EnterpriseRepository::class)
            ->getByDefaultAccountingExpense($mission->customer);

        if (is_null($line->accountingExpense()->first()) && ! is_null($default_accounting_expense)) {
            $line->accountingExpense()->associate($default_accounting_expense)->save();
        }

        $line->refresh();

        return $line;
    }

    private function sendErrorToAirtable(Airtable $client, string $id, string $msg_error)
    {
        $data = [
            'records' => [
                [
                    'id' => $id,
                    'fields' => [
                        'msg_error_addw_platform_statut_4' => $msg_error,
                        'error_addw_platform_status_4' => true,
                    ]
                ]
            ]
        ];

        $client->updateRecord(self::TABLE, $data);
    }
}
