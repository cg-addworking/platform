<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Mission\Mission\Application\Models\Mission;

interface MissionRepositoryInterface
{
    public function find(string $id): ?Mission;
    public function findByNumber(int $number): ?Mission;
    public function make(array $data = []): Mission;
    public function getMissionsFor(Enterprise $enterprise);
    public function getOrCreateMissionFromInput(array $inputs, ContractEntityInterface $contract): ?Mission;
    public function getMissionsBetween(Enterprise $customer, Enterprise $vendor);
    public function getPartners(Mission $mission);
}
