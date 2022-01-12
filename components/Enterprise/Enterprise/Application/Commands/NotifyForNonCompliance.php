<?php

namespace Components\Enterprise\Enterprise\Application\Commands;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Notifications\Addworking\Enterprise\VendorNoncomplianceNotification;
use App\Repositories\Addworking\Enterprise\ComplianceEnterpriseRepository;
use Components\Enterprise\Enterprise\Application\Repositories\EnterpriseRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;

class NotifyForNonCompliance extends Command
{
    protected $signature = 'enterprise:notify-for-non-compliance';

    protected $description = 'Checks for vendors non compliance per clients';

    protected $enterpriseRepository;

    public function __construct(EnterpriseRepository $enterpriseRepository)
    {
        parent::__construct();

        $this->enterpriseRepository = $enterpriseRepository;
    }

    public function handle()
    {
        foreach (Enterprise::ofType('customer')->cursor() as $customer) {
            $customer_compliance_managers = App::make(ComplianceEnterpriseRepository::class)
                ->getCustomerComplianceManagers($customer)
                ->get();

            if (empty($customer_compliance_managers)) {
                unset($customer_compliance_managers);
                continue;
            }

            $vendors = $customer->vendors()->orderBy('name')->cursor();

            if (empty($vendors)) {
                unset($vendors);
                continue;
            }

            $non_compliant_vendors = [];

            foreach ($vendors as $vendor) {
                if (! $this->enterpriseRepository->checkPartnershipActivity($customer, $vendor)) {
                    continue;
                }

                if (! $this->enterpriseRepository->isCompliantFor($vendor, $customer)) {
                    $non_compliant_vendors[] = $vendor;
                    continue;
                }

                unset($vendor);
                gc_collect_cycles();
            }

            if (! empty($non_compliant_vendors)) {
                Notification::send(
                    $customer_compliance_managers,
                    new VendorNoncomplianceNotification(
                        $customer,
                        $non_compliant_vendors
                    )
                );
            }
            unset($customer);
            unset($non_compliant_vendors);
            gc_collect_cycles();
        }
    }
}
