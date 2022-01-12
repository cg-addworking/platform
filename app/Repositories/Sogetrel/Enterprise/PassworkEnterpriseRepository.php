<?php

namespace App\Repositories\Sogetrel\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Sogetrel\User\Passwork;
use Illuminate\Database\Eloquent\Collection;

class PassworkEnterpriseRepository implements RepositoryInterface
{
    public function hasSogetrelPasswork(Enterprise $enterprise): bool
    {
        return $enterprise->users()->get()->contains(
            fn($user) => $user->sogetrelPasswork()->exists()
        );
    }

    public function getEnterpriseSogetrelPasswork(Enterprise $enterprise): ?Passwork
    {
        foreach ($enterprise->users()->get() as $user) {
            if ($user->sogetrelPasswork()->exists()) {
                return $user->sogetrelPasswork;
            }
        }
        return null;
    }

    public function hasTagSoconnext(Enterprise $enterprise): bool
    {
        return $enterprise->users()->withAllTags('sogetrel.soconnext')->exists();
    }

    public function passworks(Enterprise $enterprise): Collection
    {
        return Passwork::whereHas('user', function ($q) use ($enterprise) {
            return $q->whereHas('enterprises', function ($q) use ($enterprise) {
                return $q->whereId($enterprise->id);
            });
        })->get();
    }
}
