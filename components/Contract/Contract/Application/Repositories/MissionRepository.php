<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Milestone;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\MissionRepositoryInterface;
use Components\Contract\Model\Domain\Exceptions\MissionCreationFailedException;
use Components\Mission\Mission\Application\Models\Mission;
use Components\Mission\Mission\Domain\Interfaces\MissionEntityInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class MissionRepository implements MissionRepositoryInterface
{
    private $enterpriseRepository;

    public function __construct()
    {
        $this->enterpriseRepository = new EnterpriseRepository();
    }

    public function save(MissionEntityInterface $mission)
    {
        try {
            $mission->save();
        } catch (MissionCreationFailedException $exception) {
            throw $exception;
        }

        $mission->refresh();

        return $mission;
    }

    public function find(string $id): ?Mission
    {
        return Mission::where('id', $id)->first();
    }

    public function make($data = []): Mission
    {
        return new Mission($data);
    }

    public function getMissionsFor(Enterprise $enterprise)
    {
        return Mission::query()
            ->when($enterprise->isVendor(), function ($query) use ($enterprise) {
                $query->ofVendor($enterprise);
            })
            ->when($enterprise->isCustomer(), function ($query) use ($enterprise) {
                $query->ofCustomer($enterprise);
            })
            ->with('vendor')
            ->get();
    }

    public function getMissionsBetween(Enterprise $customer, Enterprise $vendor)
    {
        return Mission::query()
            ->ofVendor($vendor)
            ->ofCustomer($customer)
            ->get();
    }

    public function findByNumber(int $number): ?Mission
    {
        return Mission::where('number', $number)->first();
    }

    public function getOrCreateMissionFromInput(array $inputs, ContractEntityInterface $contract): ?Mission
    {
        if (isset($inputs['mission']['id'])) {
            return $this->find($inputs['mission']['id']);
        }

        $data = [
            "label" => $inputs['mission']['label'],
            "starts_at" => $inputs['mission']['starts_at'],
            "ends_at" => $inputs['mission']['ends_at'],
            "unit" => MissionEntityInterface::UNIT_DAYS,
            "quantity" => "1",
            "unit_price" => 0,
            'status' => MissionEntityInterface::STATUS_DRAFT,
            'milestone_type' => Milestone::MILESTONE_MONTHLY,
        ];

        $mission = $this->make($data);

        $vendor = $this->enterpriseRepository->find($inputs['mission']['vendor_id']);

        $mission->setNumber();

        $mission
            ->customer()->associate($contract->getEnterprise())
            ->vendor()->associate($vendor)
            ->save();

        App::make(MilestoneRepository::class)->createFromMission($mission);

        return $mission;
    }

    public function getPartners(Mission $mission)
    {
        return new Collection([$mission->customer, $mission->vendor]);
    }
}
