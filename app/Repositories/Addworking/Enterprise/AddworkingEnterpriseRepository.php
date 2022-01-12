<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Repositories\Addworking\User\AddworkingUserRepository;

class AddworkingEnterpriseRepository implements RepositoryInterface
{
    protected $user;
    protected $enterprise;

    public function __construct(AddworkingUserRepository $user, EnterpriseRepository $enterprise)
    {
        $this->user = $user;
        $this->enterprise = $enterprise;
    }

    public function getAddworkingEnterprise(): Enterprise
    {
        $query = Enterprise::withTrashed()->where('name', "ADDWORKING");

        if (! $query->exists()) {
            return $this->createAddworkingEnterprise();
        }

        return $query->firstOrFail();
    }

    protected function createAddworkingEnterprise(): Enterprise
    {
        $enterprise = $this->enterprise->create([
            'name'                  => "ADDWORKING",
            'identification_number' => "81084090000015",
            'registration_town'     => "Annecy",
        ]);

        // this method will automatically attach
        // Julien PERONA to Addworking
        $user = $this->user->getJulienPeronaUser();

        return $enterprise;
    }

    /**
     * @deprecated v0.5.62 replace with Addworking::is($enterprise)
     */
    public function isAddworking(Enterprise $enterprise): bool
    {
        return $enterprise->name == 'ADDWORKING';
    }
}
