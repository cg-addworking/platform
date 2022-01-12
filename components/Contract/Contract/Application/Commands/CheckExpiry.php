<?php

namespace Components\Contract\Contract\Application\Commands;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Carbon\Carbon;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Notifications\ContractExpiringCustomerNotification;
use Components\Contract\Contract\Application\Notifications\ContractExpiringVendorNotification;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;

class CheckExpiry extends Command
{
    protected $signature = 'contract:check-expiry {--day=* : days to notify for expiration}';

    protected $description = 'check contract expiry';

    protected $contractRepository;

    public function __construct(ContractRepository $contractRepository)
    {
        parent::__construct();

        $this->contractRepository = $contractRepository;
    }

    public function handle()
    {
        $enterprises_with_active_contracts = Enterprise::whereHas('contracts', function ($query) {
                $query->whereNull('parent_id')
                      ->where('state', Contract::STATE_ACTIVE)
                      ->cursor()
                      ->filter(function ($contract) {
                          return !is_null($this->contractRepository->getValidUntilDate($contract));
                      });
        })->get();

        foreach ($this->option('day') as $parameter) {
            $day = explode(",", $parameter)[0];
            $notify_other_party = (bool)explode(",", $parameter)[1];

            foreach ($enterprises_with_active_contracts as $enterprise) {
                $contracts_to_notify = $this->getContractsToNotifyFor($enterprise, $day);

                if ($contracts_to_notify->count() > 0) {
                    $this->notify($contracts_to_notify, $day, $enterprise, $notify_other_party);
                }
            }
        }
    }

    private function getContractsToNotifyFor($enterprise, $day)
    {
        $contracts_to_notify = new Collection;

        $active_contracts = Contract::whereNull('parent_id')
            ->whereHas('enterprise', function ($query) use ($enterprise) {
                return $query->where('id', $enterprise->id);
            })
            ->where('state', Contract::STATE_ACTIVE)
            ->cursor()
            ->filter(function ($contract) {
                return ! is_null($this->contractRepository->getValidUntilDate($contract));
            });

        foreach ($active_contracts as $contract) {
            if (Carbon::now()->toDateString() === $this->contractRepository->getValidUntilDate($contract)
                    ->subDays($day)->toDateString()) {
                $contracts_to_notify->push($contract);
            }
        }

        return $contracts_to_notify;
    }

    private function notify($contracts, $day, $enterprise, bool $notify_other_party = false)
    {
        foreach ($this->getUniqueEntitiesToNotify($contracts, $notify_other_party, $enterprise) as $entity) {
            foreach ($entity as $type => $data) {
                switch ($type) {
                    case 'customer':
                        Notification::send(
                            $data['user'],
                            new ContractExpiringCustomerNotification($data['enterprise'], $day)
                        );
                        break;

                    case 'vendor':
                        Notification::send(
                            $data['user'],
                            new ContractExpiringVendorNotification($data['contract'], $day)
                        );
                        break;
                }
                if ($type === 'vendor' && $day === "30") {
                    ActionTrackingHelper::track(
                        null,
                        ActionEntityInterface::CONTRACT_PRE_EXPIRE_NOTIFICATION,
                        $data['contract'],
                        __('components.contract.contract.application.tracking.contract_pre_expire_notification')
                    );
                }
            }
        }
    }

    private function getUniqueEntitiesToNotify($contracts, $notify_other_party, $enterprise)
    {
        $entities = new Collection;

        // we get the customer compliance managers
        $enterprise->users()->wherePivot(User::IS_CUSTOMER_COMPLIANCE_MANAGER, true)->get()
            ->map(function ($user) use ($entities, $enterprise) {
                $entities->push([
                    'customer' => [
                        'user' => $user,
                        'enterprise' => $enterprise,
                    ]
                ]);
            });

        //we want to send also to the other party signatory
        foreach ($contracts as $contract) {
            $this->getEntitiesToNotify($contract, $notify_other_party)->map(function ($entity) use ($entities) {
                $entities->push($entity);
            });
        }

        return $entities->unique();
    }

    private function getEntitiesToNotify(Contract $contract, bool $notify_other_party = false)
    {
        $entities = new Collection;

        if ($notify_other_party) {
            $ancestors = App::make(FamilyEnterpriseRepository::class)
                ->getAncestors($contract->getEnterprise(), true)
                ->pluck('id');

            $parties = $contract->getParties()->filter(function ($party) use ($ancestors) {
                return ! $ancestors->contains($party->getEnterprise()->id);
            });

            $parties->map(function ($party) use ($entities, $contract) {
                $entities->push([
                    'vendor' => [
                        'user' => $party->getSignatory(),
                        'contract' => $contract,
                    ]
                ]);
            });
        }

        return $entities;
    }
}
