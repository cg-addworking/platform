<?php

namespace App\Repositories\Addworking\User;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\AddworkingEnterpriseRepository;
use App\Repositories\Addworking\User\UserRepository;
use Illuminate\Support\Facades\DB;

class AddworkingUserRepository implements RepositoryInterface
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function getJulienPeronaUser(): User
    {
        $query = User::where('email', "julien@addworking.com");

        if (! $query->exists()) {
            return $this->createJulienPeronaUser();
        }

        return $query->firstOrFail();
    }

    protected function createJulienPeronaUser(): User
    {
        return DB::transaction(function () {
            $user = $this->user->create([
                'gender'    => "male",
                'email'     => "julien@addworking.com",
                'password'  => "",
                'firstname' => "Julien",
                'lastname'  => "PERONA",
            ]);

            // do NOT add this to the constructor as it would create a circular
            // reference!
            $addworking = app(AddworkingEnterpriseRepository::class)->getAddworkingEnterprise();

            $addworking->users()->attach($user, [
                'job_title'               => "CEO",
                'primary'                 => true,
                'current'                 => true,
                'is_signatory'            => true,
                'is_legal_representative' => true,
            ]);

            return $user;
        });
    }

    public function getSystemUser(): User
    {
        $query = User::where('id', '00000000-0000-0000-0000-000000000000');

        if (! $query->exists()) {
            return $this->createSystemUser();
        }

        return $query->firstOrFail();
    }

    protected function createSystemUser(): User
    {
        return User::unguarded(function () {
            return User::create([
                'id'        => "00000000-0000-0000-0000-000000000000",
                'number'    => "0",
                'gender'    => "male",
                'email'     => "system@addworking.com",
                'password'  => "",
                'firstname' => "Rob",
                'lastname'  => "BOTT",
            ]);
        });
    }
}
