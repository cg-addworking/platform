<?php

namespace App\Repositories\Addworking\Mission;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseCollection;
use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\ProposalResponse;
use App\Models\Addworking\User\User;
use App\Models\Everial\Mission\Price;
use App\Models\Everial\Mission\Referential;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MissionRepository extends BaseRepository
{
    protected $model = Mission::class;

    protected $milestone;
    protected $familyEnterpriseRepository;

    public function __construct(
        MilestoneRepository $milestone,
        FamilyEnterpriseRepository $familyEnterpriseRepository
    ) {
        $this->milestone = $milestone;
        $this->familyEnterpriseRepository = $familyEnterpriseRepository;
    }

    public function createFromRequest(Request $request): Mission
    {
        return DB::transaction(function () use ($request) {
            $mission = self::make($request->input('mission'));

            $mission->vendor()->associate($request->input('vendor.id'));
            $mission->customer()->associate($request->input('customer.id'));
            $mission->save();

            $this->milestone->createFromMission($mission);

            return $mission;
        });
    }

    public function getAvailableVendors(User $user): Collection
    {
        $enterprise = $user->enterprise;

        if ($user->isSupport()) {
            return Enterprise::whereIsVendor()->orderBy('name')->get();
        }

        if ($enterprise->isVendor() && $enterprise->isCustomer()) {
            return $enterprise->vendors()->get()->push($enterprise)->sortBy('name');
        }

        if ($enterprise->isVendor() && ! $enterprise->isCustomer()) {
            return collect([$enterprise]);
        }

        if (! $enterprise->isVendor() && $enterprise->isCustomer()) {
            return $enterprise->vendors()->orderBy('name')->get();
        }

        return collect([]);
    }

    public function getAvailableCustomers(User $user): Collection
    {
        $enterprise = $user->enterprise;

        if ($user->isSupport()) {
            return Enterprise::whereIsCustomer()->orderBy('name')->get();
        }

        if ($enterprise->isVendor() && $enterprise->isCustomer()) {
            return $enterprise->customers()->get()->push($enterprise)->sortBy('name');
        }

        if ($enterprise->isVendor() && ! $enterprise->isCustomer()) {
            return $enterprise->customers()->orderBy('name')->get();
        }

        if (! $enterprise->isVendor() && $enterprise->isCustomer()) {
            return collect([$enterprise]);
        }

        return collect([]);
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return Mission::query()
            ->when($filter['starts_at'] ?? null, function ($query, $date) {
                return $query->filterStartsAt($date);
            })
            ->when($filter['status'] ?? null, function ($query, $status) {
                return $query->status($status);
            })
            ->when($filter['label'] ?? null, function ($query, $label) {
                return $query->filterLabel($label);
            })
            ->when($filter['vendor'] ?? null, function ($query, $vendor) {
                return $query->filterVendor($vendor);
            })
            ->when($filter['customer'] ?? null, function ($query, $customer) {
                return $query->filterCustomer($customer);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function createFromProposalResponse(ProposalResponse $response): Mission
    {
        return DB::transaction(function () use ($response) {
            $proposal = $response->proposal;
            $offer = $proposal->offer;

            $data = [
                'label' => $offer->label,
                'description' => $offer->description,
                'starts_at' => $response->starts_at,
                'ends_at' => $response->ends_at,
                'unit' => $response->unit ?? Mission::UNIT_FIXED_FEES,
                'quantity' => $response->quantity ?? 0,
                'unit_price' => $response->unit_price ?? 0,
                'status' => Mission::STATUS_READY_TO_START,
            ];

            $mission = self::make($data);
            $mission->customer()->associate($offer->customer);
            $mission->vendor()->associate($proposal->vendor);
            $mission->offer()->associate($offer);
            $mission->proposal()->associate($proposal);
            $mission->proposalResponse()->associate($response);
            $mission->createdBy()->associate($offer->customer);

            $mission->save();

            return $mission;
        });
    }

    public function createFromOffer(Offer $offer, Enterprise $vendor, Request $request): Mission
    {
        $data = [
            'label' => $offer->label,
            'description' => $offer->description,
            'starts_at' => $offer->starts_at_desired,
            'ends_at' => $offer->ends_at,
            'unit' => Mission::UNIT_FIXED_FEES,
            'quantity' => 1,
            'unit_price' => $this->getUnitPrice($offer, $vendor),
            'status' => Mission::STATUS_READY_TO_START,
        ];

        return DB::transaction(function () use ($data, $vendor, $offer, $request) {
            $mission = self::make($data);
            $mission->vendor()->associate($vendor);
            $mission->customer()->associate($offer->customer);
            $mission->offer()->associate($offer);
            $mission->save();

            if ($request->has('close_offer')) {
                $offer->update(['status' => Offer::STATUS_CLOSED]);
            }

            return $mission;
        });
    }

    public function close(Mission $mission, User $closed_by): bool
    {
        return DB::transaction(function () use ($mission, $closed_by) {
            if (! $mission->hasMilestoneType()) {
                $this->milestone->createFromMission(tap($mission)->update([
                    'ends_at'        => $mission->ends_at ?: Carbon::now(),
                    'milestone_type' => Milestone::MILESTONE_END_OF_MISSION,
                ]));
            }

            return $mission->update([
                'closed_by' => $closed_by->id,
                'closed_at' => Carbon::now(),
                'status'    => Mission::STATUS_CLOSED,
            ]);
        });
    }

    protected function getUnitPrice(Offer $offer, Enterprise $vendor)
    {
        $spf = Enterprise::fromName('SPF - SOCIETE DE PARTICIPATIONS FINANCIERES');

        $is_everial = $this->familyEnterpriseRepository->getFamily($spf)->contains($offer->customer);

        if ($is_everial) {
            $referential = $offer->everialReferentialMissions()->latest()->first();

            if ($referential->prices->count() > 0) {
                return $referential->prices()->whereHas('vendor', function ($query) use ($vendor) {
                    $query->where('id', $vendor->id);
                })->latest()->first()->amount ?? 0;
            }
        }

        return 0;
    }
}
