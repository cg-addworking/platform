<?php

namespace Components\Enterprise\ActivityReport\Application\Commands;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Carbon\Carbon;
use Components\Enterprise\ActivityReport\Application\Notifications\RequestActivityReportNotification;
use Components\Enterprise\ActivityReport\Application\Repositories\ActivityReportRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class RequestActivityReport extends Command
{
    protected $signature = 'enterprise:request-activity-report {customer} {year} {month}';

    protected $description = 'Request customer vendors current month activity report';

    private $activityReportRepository;
    private $familyEnterpriseRepository;

    public function __construct(
        ActivityReportRepository $activityReportRepository,
        FamilyEnterpriseRepository $familyEnterpriseRepository
    ) {
        parent::__construct();

        $this->activityReportRepository = $activityReportRepository;
        $this->familyEnterpriseRepository = $familyEnterpriseRepository;
    }
    public function handle()
    {
        $customer = Enterprise::findOrFail($this->argument('customer'));

        $vendors = $this->getVendorsToNotify($customer);

        Log::info("Vendors to notify : ".count($vendors));
        $bar = $this->output->createProgressBar(count($vendors));
        $bar->start();
        foreach ($vendors as $vendor) {
            $this->sendNotification($vendor, $customer);
            $bar->advance();
        }
        $bar->finish();
    }

    private function getUserToNotify(Enterprise $vendor)
    {
        return $vendor->users()->where('is_active', true)->get();
    }

    private function getVendorsToNotify(Enterprise $customer)
    {
        $descendants = $this->familyEnterpriseRepository
            ->getDescendants($customer, true);

        $vendors = new Collection;

        foreach ($descendants as $customer) {
            $vendors->push($customer->vendors()->get()->filter(function ($vendor) use ($customer) {
                return $vendor->vendorInActivityWithCustomer($customer);
            }));
        }

        return $vendors->flatten()->unique('id')->values()->all();
    }

    private function sendNotification(Enterprise $vendor, Enterprise $customer)
    {
        $users = $this->getUserToNotify($vendor);

        $given_date = $this->argument('year') . $this->argument('month');

        $date = Carbon::createFromFormat('Ym', $given_date);

        if (is_null($this->activityReportRepository->getActivityReportAt($vendor, $date)) &&
            count($users)) {
            Notification::send(
                $users,
                new RequestActivityReportNotification($vendor, $customer, $date)
            );
        }
    }
}
