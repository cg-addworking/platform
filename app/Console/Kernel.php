<?php

namespace App\Console;

use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $this->scheduleNotifyForNonCompliance($schedule);

        $this->scheduleRequestingActivityReportsForSogetrel($schedule);

        $this->scheduleSendingActivityReportsToSupport($schedule);

        $this->scheduleSendingVendorDocumentToSogetrelFTP($schedule);

        $this->scheduleSendingVendorInformationsToSogetrelNavibat($schedule);

        $this->scheduleSetContractStatus($schedule);

        $this->scheduleSendingContractEmailFollowups($schedule);

        $this->scheduleCreateSogetrelAttachmentFromAirtable($schedule);

        $this->scheduleCheckContractExpiry($schedule);

        $this->scheduleUnfinishedOnboardingReminder($schedule);

        $this->scheduleCreateMilestoneMission($schedule);

        $this->scheduleExtractDataFromSogetrelAttachmentFile($schedule);

        $this->scheduleEnterpriseDocumentExpiration($schedule);

        $this->scheduleSyncAwsWithScaleway($schedule);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    private function scheduleNotifyForNonCompliance($schedule)
    {
        if (config('scheduler.notifying-for-non-compliance')) {
            $schedule
                ->command('enterprise:notify-for-non-compliance')
                ->mondays()
                ->timezone('Europe/Paris')
                ->at('15:00')
                ->emailOutputOnFailure('nadir@addworking.com')
                ->environments(['production']);
        }
    }

    private function scheduleRequestingActivityReportsForSogetrel($schedule)
    {
        if (config('scheduler.requesting_activity_reports_for_sogetrel')) {
            $id = Enterprise::fromName('SOGETREL')->id;
            $date = Carbon::now();

            $end_of_month_minus_five_days = $date->endOfMonth()->subDays(5)->day;
            $end_of_month_minus_two_days = $date->endOfMonth()->subDays(2)->day;

            $schedule
                ->command("enterprise:request-activity-report {$id} {$date->year} {$date->month}")
                ->timezone('Europe/Paris')
                ->twiceMonthly($end_of_month_minus_five_days, $end_of_month_minus_two_days, '18:30')
                ->emailOutputOnFailure('nadir@addworking.com')
                ->environments(['production']);

            $wanted_date = $date->subMonth();

            $schedule
                ->command("enterprise:request-activity-report {$id} {$wanted_date->year} {$wanted_date->month}")
                ->timezone('Europe/Paris')
                ->twiceMonthly('1', '3', '18:30')
                ->emailOutputOnFailure('nadir@addworking.com')
                ->environments(['production']);
        }
    }

    private function scheduleSendingActivityReportsToSupport($schedule)
    {
        if (config('scheduler.sending_activity_reports_to_support')) {
            $schedule
                ->command("enterprise:send-activity-reports")
                ->timezone('Europe/Paris')
                ->monthlyOn('5', '18:30')
                ->emailOutputOnFailure('nadir@addworking.com')
                ->environments(['production']);
        }
    }

    private function scheduleSendingVendorDocumentToSogetrelFTP($schedule)
    {
        if (config('scheduler.sending_vendor_document_to_sogetrel_ftp')) {
            $schedule
                ->command("sogetrel:enterprise:send-documents-to-ftp")
                ->timezone('Europe/Paris')
                ->dailyAt('17:30')
                ->emailOutputOnFailure('nadir@addworking.com')
                ->environments(['production']);
        }
    }

    private function scheduleSendingVendorInformationsToSogetrelNavibat($schedule)
    {
        if (config('scheduler.sending_vendor_informations_to_sogetrel_navibat')) {
            $schedule
                ->command("sogetrel:enterprise:send-vendors-to-navibat")
                ->timezone('Europe/Paris')
                ->twiceDaily(1, 13)
                ->emailOutputOnFailure('nadir@addworking.com')
                ->environments(['production']);
        }
    }

    private function scheduleSetContractStatus($schedule)
    {
        if (config('scheduler.set_contract_state')) {
            $schedule
                ->command("contract:set-state")
                ->timezone('Europe/Paris')
                ->dailyAt('00:30')
                ->emailOutputOnFailure('nadir@addworking.com')
                ->environments(['production']);
        }
    }

    private function scheduleSendingContractEmailFollowups($schedule)
    {
        if (config('scheduler.send_contract_email_followup')) {
            $schedule
                ->command("contract:send-request-contract-document-followup-notification")
                ->timezone('Europe/Paris')
                ->dailyAt('14:00')
                ->emailOutputOnFailure('nadir@addworking.com')
                ->environments(['production']);

            $schedule
                ->command("contract:send-sign-contract-followup-notification")
                ->timezone('Europe/Paris')
                ->dailyAt('14:00')
                ->emailOutputOnFailure('nadir@addworking.com')
                ->environments(['production']);
        }
    }

    private function scheduleCreateSogetrelAttachmentFromAirtable($schedule)
    {
        if (config('scheduler.create_sogetrel_attachments_from_airtable')) {
            $schedule
                ->command("sogetrel:create-attachments-from-airtable")
                ->timezone('Europe/Paris')
                ->everyTenMinutes()
                ->emailOutputOnFailure('nadir@addworking.com')
                ->environments(['production']);
        }
    }

    private function scheduleCheckContractExpiry($schedule)
    {
        // we notify the contract owner customer compliance managers at D - 30
        // we notify the contract owner customer compliance managers and the other party signatory ad D - 1
        if (config('scheduler.check_contract_expiry')) {
            $schedule
                ->command("contract:check-expiry --day=30,0 --day=1,1")
                ->timezone('Europe/Paris')
                ->dailyAt('08:00')
                ->emailOutputOnFailure('nadir@addworking.com')
                ->environments(['production']);
        }
    }

    private function scheduleUnfinishedOnboardingReminder($schedule)
    {
        if (config('scheduler.unfinished_onboarding_reminder')) {
            $schedule
                ->command("addworking:user:unfinished-onboarding-reminder")
                ->days([1, 3])
                ->timezone('Europe/Paris')
                ->at('09:30')
                ->emailOutputOnFailure('nadir@addworking.com')
                ->environments(['production']);
        }
    }

    private function scheduleCreateMilestoneMission($schedule)
    {
        if (config('scheduler.create_milestone_mission')) {
            $schedule
                ->command("mission:create-milestones monthly")
                ->timezone('Europe/Paris')
                ->monthlyOn(1, '02:01')
                ->emailOutputOnFailure('nadir@addworking.com')
                ->environments(['production']);
        }
    }

    private function scheduleExtractDataFromSogetrelAttachmentFile($schedule)
    {
        if (config('scheduler.extract_data_from_attachment_file')) {
            $schedule
                ->command("sogetrel:extract-data-from-attachment-file")
                ->timezone('Europe/Paris')
                ->hourly()
                ->emailOutputOnFailure(['nadir@addworking.com', 'zakaria@addworking.com',])
                ->environments(['production']);
        }
    }

    private function scheduleEnterpriseDocumentExpiration($schedule)
    {
        if (config('scheduler.notify-document-expiration')) {
            $schedule
                ->command("addworking:enterprise:notify-document-expiration")
                ->timezone('Europe/Paris')
                ->dailyAt('06:00')
                ->emailOutputOnFailure(['nadir@addworking.com'])
                ->environments(['production']);
        }
    }

    private function scheduleSyncAwsWithScaleway($schedule)
    {
        if (config('scheduler.sync-aws-with-scaleway')) {
            $schedule
                ->command("file:sync-aws-with-scaleway")
                ->timezone('Europe/Paris')
                ->dailyAt('00:01')
                ->emailOutputOnFailure(['nadir@addworking.com'])
                ->environments(['production']);
        }
    }
}
