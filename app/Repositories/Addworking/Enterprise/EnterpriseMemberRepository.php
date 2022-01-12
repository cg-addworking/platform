<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseCollection;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\User\UserRepository;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EnterpriseMemberRepository extends BaseRepository
{
    protected $model = User::class;

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        $enterprise_id = $filter['enterprise'] ?? null;

        return User::query()
            ->when($filter['name'] ?? null, function ($query, $name) {
                return $query->name($name);
            })
            ->when($filter['roles'] ?? null, function ($query, $roles) use ($enterprise_id) {
                foreach (Arr::wrap($roles) as $role) {
                    $query->whereHas('enterprises', function ($q) use ($enterprise_id, $role) {
                        return $q->where('id', $enterprise_id)->where($role, true);
                    });
                }
            })
            ->when($filter['accesses'] ?? null, function ($query, $accesses) use ($enterprise_id) {
                foreach (Arr::wrap($accesses) as $access) {
                    $query->whereHas('enterprises', function ($q) use ($enterprise_id, $access) {
                        return $q->where('id', $enterprise_id)->where($access, true);
                    });
                }
            });
    }

    public function createFromRequest(Request $request, Enterprise $enterprise): Enterprise
    {
        /** @var User $user */
        $user = $this->find($request->get('member')['id']);
        $mainEnterprisePivot = [];

        if (!isset($user->getCurrentEnterprise()->id)) {
            $mainEnterprisePivot['current'] = true;
        }

        if (!isset($user->getPrimaryEnterprise()->id)) {
            $mainEnterprisePivot['primary'] = true;
        }

        $enterprise->users()->attach(
            $user,
            $this->hydratePivotArray($request, $user, $enterprise) + $mainEnterprisePivot
        );

        if ($enterprise->users()->count() == 1) {
            self::storeRolesForEnterprise($enterprise, $user, [User::IS_ADMIN => true]);
        }

        return $enterprise;
    }

    public function updateFromRequest(Request $request, Enterprise $enterprise, User $user)
    {
        $enterprise->users()->updateExistingPivot($user, $this->hydratePivotArray($request, $user, $enterprise));

        return $user;
    }

    protected function hydratePivotArray(Request $request, User $user, Enterprise $enterprise): array
    {
        $array = [
            'job_title' => $request->get('member')['job_title'],
        ];

        foreach (User::getAvailableRoles() as $role) {
            $array[$role] = in_array($role, $request->get('member')['roles']);
        }

        foreach (User::getAvailableAccess() as $access) {
            $array[$access] = in_array(
                $access,
                $request->get('member')['accesses'] ?? $user->getAccessesFor($enterprise)
            );
        }

        return $array;
    }

    public static function storeRolesFromRequest(Request $request, User $user): bool
    {
        foreach ($user->enterprises as $enterprise) {
            $roles = array_wrap($request->get("role.{$enterprise->id}", []));

            if (! static::storeRolesForEnterprise($enterprise, $user, $roles)) {
                return false;
            }
        }

        return true;
    }

    public static function storeRolesForEnterprise(Enterprise $enterprise, User $user, array $roles): bool
    {
        $default_roles = [];
        foreach (User::getAvailableRoles() as $key) {
            $default_roles[$key] = false;
        }

        return (bool) $user->permissions()->updateExistingPivot($enterprise, $roles + $default_roles);
    }

    public static function storeAccessesFromRequest(Request $request, User $user): bool
    {
        foreach ($user->enterprises as $enterprise) {
            $accesses = array_wrap(
                $request->get("access")['$enterprise->id'] ?? $user->getAccessesFor($enterprise)
            );

            if (! static::storeAccessesForEnterprise($enterprise, $user, $accesses)) {
                return false;
            }
        }

        return true;
    }

    public static function storeAccessesForEnterprise(Enterprise $enterprise, User $user, array $accesses = []): bool
    {
        $default_accesses = [];
        foreach (User::getAvailableAccess() as $key) {
            $default_accesses[$key] = false;
        }

        return (bool) $user->permissions()->updateExistingPivot($enterprise, $accesses + $default_accesses);
    }

    public static function storeAccessesFromInvitation(Enterprise $enterprise, User $user)
    {
        $accesses = $enterprise->legalRepresentatives()->first()->getAccessesFor($enterprise);

        foreach ($accesses as $key => $access) {
            $user->permissions()->updateExistingPivot($enterprise, [$access => true]);
        }
    }

    public function isMember(Enterprise $enterprise, User $user): bool
    {
        return $enterprise->users()->where('id', $user->id)->exists();
    }

    public function getEnterprisesOf(User $user)
    {
        return Enterprise::whereHas('users', function ($query) use ($user) {
            return $query->where('id', $user->id);
        })->get();
    }

    public function memberOfCustomerAncestors($enterprises, User $user): bool
    {
        $is_member = false;

        foreach ($enterprises as $enterprise) {
            if ($this->isMember($enterprise, $user)) {
                $is_member = true;
            }
        }

        return $is_member;
    }
}
