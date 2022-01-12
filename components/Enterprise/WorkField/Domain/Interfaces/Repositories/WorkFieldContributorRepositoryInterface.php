<?php
namespace Components\Enterprise\WorkField\Domain\Interfaces\Repositories;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldContributorEntityInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;

interface WorkFieldContributorRepositoryInterface
{
    public function make($data = []): WorkFieldContributorEntityInterface;
    public function save(
        WorkFieldContributorEntityInterface $work_field_contributor
    ): WorkFieldContributorEntityInterface;
    public function findByNumber(int $number): ?WorkFieldContributorEntityInterface;
    public function getAdminsOf(WorkFieldEntityInterface $work_field);
    public function getContributorsOf(WorkFieldEntityInterface $work_field);
    public function isAdminOf(User $user, WorkFieldEntityInterface $work_field): bool;
    public function find($id): ?WorkFieldContributorEntityInterface;
    public function isContributorOf(User $user, WorkFieldEntityInterface $work_field): bool;
    public function delete(WorkFieldContributorEntityInterface $work_field_contributor);
    public function isContributor(User $user): bool;
    public function getWorkfieldContributorContractValidators(WorkFieldEntityInterface $work_field);
    public function getAvailableRoles(bool $trans = false): array;
}
