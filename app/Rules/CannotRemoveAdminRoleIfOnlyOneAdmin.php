<?php

namespace App\Rules;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Contracts\Validation\Rule;

class CannotRemoveAdminRoleIfOnlyOneAdmin implements Rule
{
    protected $user_to_update;
    protected $enterprise;

    public function __construct(User $user_to_update, Enterprise $enterprise)
    {
        $this->user_to_update = $user_to_update;
        $this->enterprise = $enterprise;
    }

    public function passes($attribute, $value)
    {
        $nb_admin_user = $this->enterprise->users()->wherePivot(User::IS_ADMIN, true)->count();
        $is_removing_admin_role = !in_array(User::IS_ADMIN, $value ?? []);

        if ($this->user_to_update->isAdminFor($this->enterprise) && $is_removing_admin_role && $nb_admin_user === 1) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return "Vous ne pouvez pas retirer le role admin au seul utilisateur admin de l'entreprise !!";
    }
}
