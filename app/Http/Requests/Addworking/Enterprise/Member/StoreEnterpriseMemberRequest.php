<?php

namespace App\Http\Requests\Addworking\Enterprise\Member;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEnterpriseMemberRequest extends FormRequest
{
    public function rules()
    {
        return (new UpdateEnterpriseMemberRequest)->updateRules() + [
            'member.id'  => [
                "required",
                "exists:addworking_user_users,id",
                "uuid",
                function ($attribute, $value, $fail) {
                    if ($this->route()->parameter('enterprise')->users()->where('id', $value)->exists()) {
                        $fail("L'utilisateur est déjà associé à cette entreprise !");
                    }
                }
            ],
        ];
    }
}
