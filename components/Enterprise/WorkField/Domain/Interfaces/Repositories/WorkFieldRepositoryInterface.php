<?php

namespace Components\Enterprise\WorkField\Domain\Interfaces\Repositories;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;

interface WorkFieldRepositoryInterface
{
    public function make($data = []): WorkFieldEntityInterface;
    public function save(WorkFieldEntityInterface $work_field): WorkFieldEntityInterface;
    public function findByNumber(int $number, ?bool $trashed = null): ?WorkFieldEntityInterface;
    public function getCustomersWithConstructionSector();
    public function isCreatorOf(User $user, WorkFieldEntityInterface $work_field);
    public function getOwnerEnterprisesWithConstructionSector(User $user);
    public function hasAccessToWorkField(User $user, ?WorkFieldEntityInterface $work_field): bool;
    public function delete(WorkFieldEntityInterface $work_field): bool;
    public function isDeleted(string $number): bool;
    public function getSearchableAttributes(): array;
}
