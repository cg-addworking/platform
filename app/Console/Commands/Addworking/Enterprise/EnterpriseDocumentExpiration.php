<?php

namespace App\Console\Commands\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Notifications\Addworking\Enterprise\DocumentExpiryNotification;
use App\Notifications\Addworking\Enterprise\DocumentOutdatedNotification;
use App\Repositories\Addworking\Enterprise\AddworkingEnterpriseRepository;
use App\Repositories\Addworking\Enterprise\CustomerRepository;
use Carbon\Carbon;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;

class EnterpriseDocumentExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addworking:enterprise:notify-document-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $enterprises = Enterprise::has('documents')->cursor();

        $bar = $this->output->createProgressBar(count($enterprises));
        $bar->start();

        foreach ($enterprises as $enterprise) {
            $docs_before_15_days = $this->getDocuments($enterprise, 15);
            $this->send($enterprise, $docs_before_15_days, 15);

            $docs_before_3_days = $this->getDocuments($enterprise, 3);
            $this->send($enterprise, $docs_before_3_days, 3);

            $docs_0_days = $this->getDocuments($enterprise);
            $this->send($enterprise, $docs_0_days);

            $docs_3_days = $this->getDocuments($enterprise, 3, true);
            $this->send($enterprise, $docs_3_days, -3, true);

            $docs_6_days = $this->getDocuments($enterprise, 6, true);
            $this->send($enterprise, $docs_6_days, -6, true);

            $docs_9_days = $this->getDocuments($enterprise, 9, true);
            $this->send($enterprise, $docs_9_days, -9, true);

            $docs_12_days = $this->getDocuments($enterprise, 12, true);
            $this->send($enterprise, $docs_12_days, -12, true);

            $docs_18_days = $this->getDocuments($enterprise, 18, true);
            $this->send($enterprise, $docs_18_days, -18, true);

            $docs_24_days = $this->getDocuments($enterprise, 24, true);
            $this->send($enterprise, $docs_24_days, -24, true);

            $docs_30_days = $this->getDocuments($enterprise, 30, true);
            $this->send($enterprise, $docs_30_days, -30, true);

            $docs_45_days = $this->getDocuments($enterprise, 45, true);
            $this->send($enterprise, $docs_45_days, -45, true);

            $docs_60_days = $this->getDocuments($enterprise, 60, true);
            $this->send($enterprise, $docs_60_days, -60, true);

            $bar->advance();
            gc_collect_cycles();
        }

        $bar->finish();

        return 0;
    }

    private function send(Enterprise $enterprise, $documents, int $expire_in = 0, bool $outdated = false)
    {
        if (count($documents) == 0) {
            return 0;
        }

        $users = $enterprise->users()->wherePivot(User::IS_VENDOR_COMPLIANCE_MANAGER, true)->get();

        if (count($users)) {
            if ($outdated || $expire_in == 0) {
                Notification::send($users, new DocumentOutdatedNotification($enterprise, $documents));
            } else {
                Notification::send($users, new DocumentExpiryNotification($enterprise, $expire_in, $documents));
            }

            foreach ($documents as $document) {
                $document->update(['last_notified_at' => Carbon::now()]);

                if (! is_null($document->getDocumentType())) {
                    $this->setActionTracking($document, $outdated, $users, $expire_in);
                }
            }
        }

        return 1;
    }

    private function getDocuments(Enterprise $enterprise, int $days = 0, bool $outdated = false)
    {
        $query = Document::whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        })->whereHas('documentType', function ($query) use ($enterprise) {
            $query->whereHas('enterprise', function ($query) use ($enterprise) {
                $addworking = App::make(AddworkingEnterpriseRepository::class)->getAddworkingEnterprise();
                $customers = App::make(CustomerRepository::class)
                    ->getActiveCustomersAndAncestorsOf($enterprise, true)
                    ->push($addworking);

                $query->whereIn('id', $customers->pluck('id'));
            });
            $query->whereHas('legalForms', function ($query) use ($enterprise) {
                $query->where('id', $enterprise->legalForm->id);
            });
        })->whereNotNull('valid_until');

        if ($outdated) {
            $validUntil = Carbon::today()->startOfDay()->subDays($days);
            $query->where('status', Document::STATUS_OUTDATED)->where('valid_until', $validUntil->toDateString());
        } else {
            if ($days == 0) {
                $validUntil = Carbon::today()->startOfDay()->subDay();
                $query->where('status', Document::STATUS_VALIDATED)->where('valid_until', $validUntil->toDateString());
            } else {
                $validUntil = Carbon::today()->startOfDay()->addDays($days);
                $query->where('status', Document::STATUS_VALIDATED)->where('valid_until', $validUntil->toDateString());
            }
        }

        $documents = $query->get();

        if ($days == 0 && count($documents)) {
            Document::whereIn('id', $documents->pluck('id'))->update(['status' => Document::STATUS_OUTDATED]);
        }

        return $documents;
    }

    private function setActionTracking($document, bool $outdated, $users, $expire_in)
    {
        if ($outdated) {
            if ($users->count() === 1) {
                $message = __(
                    'addworking.enterprise.document.tracking.outdated',
                    [
                        'user_name' => $users->first()->name,
                        'doc_type_name' => $document->documentType->display_name,
                    ]
                );
            } elseif ($users->count() > 1) {
                $message = __(
                    'addworking.enterprise.document.tracking.outdated_many_users',
                    [
                        'user_name' => $users->first()->name,
                        'doc_type_name' => $document->documentType->display_name,
                    ]
                );
            }

            ActionTrackingHelper::track(
                null,
                ActionEntityInterface::OUTDATED_DOCUMENT_TYPE_NOTIFICATION,
                $document,
                $message
            );
        } elseif ($expire_in == 0) {
            ActionTrackingHelper::track(
                null,
                ActionEntityInterface::EXPIRE_DOCUMENT_TYPE_NOTIFICATION,
                $document,
                __(
                    'addworking.enterprise.document.tracking.expire',
                    [
                        'doc_type_name' => $document->documentType->display_name,
                        'enterprise_name' => $document->enterprise->name,
                    ]
                )
            );
        } else {
            if ($users->count() === 1) {
                $message = __(
                    'addworking.enterprise.document.tracking.expired',
                    [
                        'user_name' => $users->first()->name,
                        'doc_type_name' => $document->documentType->display_name,
                        'expire_in' => $expire_in,
                    ]
                );
            } elseif ($users->count() > 1) {
                $message = __(
                    'addworking.enterprise.document.tracking.expired_many_users',
                    [
                        'doc_type_name' => $document->documentType->display_name,
                        'expire_in' => $expire_in,
                    ]
                );
            }

            ActionTrackingHelper::track(
                null,
                ActionEntityInterface::EXPIRED_DOCUMENT_TYPE_NOTIFICATION,
                $document,
                $message
            );
        }
    }
}
