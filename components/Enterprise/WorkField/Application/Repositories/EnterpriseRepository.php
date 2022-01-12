<?php

namespace Components\Enterprise\WorkField\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Components\Enterprise\WorkField\Application\Models\Sector;
use Components\Enterprise\WorkField\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Illuminate\Support\Facades\App;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function make(): Enterprise
    {
        return new Enterprise();
    }

    public function find(string $id): ?Enterprise
    {
        return Enterprise::where('id', $id)->first();
    }

    public function findBySiret(string $siret): ?Enterprise
    {
        return Enterprise::where('identification_number', $siret)->first();
    }

    public function getOwnerAndDescendants(Enterprise $enterprise)
    {
        $construction_sector = Sector::where('name', 'construction')->first();

        return App::make(FamilyEnterpriseRepository::class)->getDescendants($enterprise, true)
            ->filter(function ($enterprise) use ($construction_sector) {
                return $enterprise->sectors()->get()->contains($construction_sector);
            });
    }
}
