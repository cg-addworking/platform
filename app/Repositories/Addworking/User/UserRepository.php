<?php

namespace App\Repositories\Addworking\User;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\EnterpriseMemberRepository;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class UserRepository extends BaseRepository
{
    protected $model = User::class;

    public function createFromRequest(Request $request): User
    {
        $data = $request->input('user');

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $phone_number = PhoneNumber::fromNumber($data['phone_number']);

        if (is_null($phone_number)) {
            $phone_number = PhoneNumber::create(['number' => $data['phone_number']]);
        }

        $user = $this->create($data);

        $user->phoneNumbers()->attach($phone_number, ['note' => "Pro"]);

        return $user;
    }

    public function addTag(User $user, string $tag)
    {
        $user->tag($tag);
    }

    public function removeTag(User $user, string $tag)
    {
        $user->untag($tag);
    }

    public function updateFromRequest(User $user, Request $request): User
    {
        $user->update($request->input('user'));

        if (is_null($request->input('user.is_system_admin'))) {
            $user->update(['is_system_admin' => false]);
        }

        if ($user->phoneNumbers->first() != $request->input('user.phone_number')) {
            $user->phoneNumbers()->detach($user->phoneNumbers->first());
            $phone_number = PhoneNumber::fromNumber($request->input('user.phone_number'));
            if (is_null($phone_number)) {
                $phone_number = PhoneNumber::create(['number' => $request->input('user.phone_number')]);
            }
            $user->phoneNumbers()->attach($phone_number, ['note' => "Pro"]);
        }

        return $user;
    }

    public function getUnreadMessagesCount($user): int
    {
        // @todo implement this method
        // return $this->find($user)->messages()->unread()->count();

        return 0;
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return User::query()
            ->when($filter['name'] ?? null, function ($query, $name) {
                return $query->name($name);
            })
            ->when($filter['email'] ?? null, function ($query, $email) {
                return $query->email($email);
            })
            ->when($filter['enterprise'] ?? null, function ($query, $enterprise) {
                return $query->filterEnterprise($enterprise);
            })
            ->when($filter['type'] ?? null, function ($query, $type) {
                return $query->ofType($type);
            })
            ->when($filter['created_at'] ?? null, function ($query, $date) {
                return $query->filterCreatedAt($date);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function swapEnterprise(User $user, Enterprise $enterprise): bool
    {
        return DB::transaction(function () use ($user, $enterprise) {
            $user->enterprises->each(function ($current) use ($user) {
                if (! $user->enterprises()->updateExistingPivot($current, ['current' => false])) {
                    throw new RuntimeException(
                        "unable to update pivot between user:$user->id and enterprise:$current->id"
                    );
                }
            });

            if (! $user->enterprises()->updateExistingPivot($enterprise, ['current' => true])) {
                throw new RuntimeException(
                    "unable to update pivot between user:$user->id and enterprise:$enterprise->id"
                );
            }

            return true;
        });
    }

    public static function storeSystemRoles(User $user, array $roles): bool
    {
        $default_roles = [];
        foreach (User::getAvailableSystemRoles() as $key) {
            $default_roles[$key] = false;
        }

        return $user->update($roles + $default_roles);
    }

    public function findEmail($id)
    {
        return User::find($id)->email;
    }

    public function isActive(User $user): bool
    {
        return $user->is_active && is_null($user->deleted_at);
    }

    public function isSupport(User $user): bool
    {
        return $user->isSupport();
    }

    /**
     * @return User|null
     */
    public function connectedUser(): ?User
    {
        return Auth::user();
    }
}
