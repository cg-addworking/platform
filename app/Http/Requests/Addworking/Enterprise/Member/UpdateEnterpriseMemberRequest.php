<?php

namespace App\Http\Requests\Addworking\Enterprise\Member;

use App\Rules\CannotRemoveAdminRoleIfOnlyOneAdmin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEnterpriseMemberRequest extends FormRequest
{
    public function updateRules()
    {
        return [
            'member.job_title' => 'required|string',
            'member.accesses'  => 'array',
            'member.roles'     => ['required', 'array']
        ];
    }

    public function rules()
    {
        $rules = $this->updateRules();
        $rules['member.roles'][] = new CannotRemoveAdminRoleIfOnlyOneAdmin(
            $this->route('user'),
            $this->route('enterprise')
        );

        return $rules;
    }
}
