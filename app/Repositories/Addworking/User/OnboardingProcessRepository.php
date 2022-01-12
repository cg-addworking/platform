<?php

namespace App\Repositories\Addworking\User;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OnboardingProcessRepository extends BaseRepository
{
    protected $model = OnboardingProcess::class;

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return OnboardingProcess::query()
            ->when($filter['user'] ?? null, function ($query, $user) {
                return $query->filterUser($user);
            })
            ->when($filter['enterprise'] ?? null, function ($query, $enterprise) {
                return $query->filterEnterprise($enterprise);
            })
            ->when($filter['customer'] ?? null, function ($query, $customer) {
                return $query->filterCustomer($customer);
            })
            ->when($filter['domain'] ?? null, function ($query, $domain) {
                return $query->whereHas('enterprise', function ($query) use ($domain) {
                    $query->where('id', $domain);
                });
            })
            ->when($filter['status'] ?? null, function ($query, $status) {
                return $query->status($status);
            })
            ->when($filter['created_at'] ?? null, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function createFromRequest(Request $request): OnboardingProcess
    {
        $data = $request->input('onboarding_process');

        if (isset($data['complete'])) {
            $data['complete'] = true;
        }

        return $this->create($data);
    }

    public function updateFromValidatedDocument(Enterprise $enterprise)
    {
        foreach ($enterprise->users as $user) {
            foreach ($user->onboardingProcesses as $onboardingProcess) {
                $onboardingProcess->update(['complete' => true]);
                $onboardingProcess->refresh();
            }
        }
    }

    public function completeFromInvitation(User $user)
    {
        $user->onboardingProcesses->first()->update(['complete' => true]);
        $user->onboardingProcesses->first()->refresh();
    }
}
