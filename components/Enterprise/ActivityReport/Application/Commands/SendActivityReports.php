<?php

namespace Components\Enterprise\ActivityReport\Application\Commands;

use Carbon\Carbon;
use Components\Enterprise\ActivityReport\Application\Builders\ActivityReportCsvBuilder;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReport;
use Components\Enterprise\ActivityReport\Application\Notifications\SendActivityReportsNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use SplFileObject;

class SendActivityReports extends Command
{
    protected $signature = "enterprise:send-activity-reports {email=support@addworking.com}";
    protected $description = 'Send activity reports to Addworking';
    protected $path;

    public function handle()
    {
        $this->path = sys_get_temp_dir()."/export";

        if (!is_dir($this->path) &&
            !mkdir($concurrentDirectory = $this->path, 0700, true)
            && !is_dir($concurrentDirectory)) {
            throw new \Exception("Unable to create directory : {$this->path}", 1);
        }

        $email = $this->argument('email');

        $csv = $this->exportActivityReports();

        $this->send($email, $csv->getPathname());
    }

    private function exportActivityReports(): SplFileObject
    {
        $date_last_month = Carbon::now()->subMonth();

        $query = ActivityReport::query()
            ->where('year', $date_last_month->year)
            ->where('month', $date_last_month->month);

        $this->info("Generating activity reports csv export...\n");
        $bar = $this->output->createProgressBar($query->count());
        $bar->start();
        $filename = 'activity-reports-' . strtolower(Carbon::now()->subMonth()->format('F-Y')).'.csv';
        $csv = (new ActivityReportCsvBuilder($this->path . '/' . $filename))
            ->addAll($query->cursor(), fn() => $bar->advance());
        $bar->finish();

        return $csv;
    }

    public function send(string $email, string $path)
    {
        Notification::route(
            'mail',
            $email
        )->notify(
            new SendActivityReportsNotification($path)
        );

        $this->info("\nExport sent to " . $email);
    }
}
