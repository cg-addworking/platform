<?php

namespace App\Http\Requests\Addworking\Enterprise\Member;

use App\Http\Requests\Addworking\User\User\StoreUserRequest;
use Illuminate\Foundation\Http\FormRequest;

class ValidateInvitationMemberRequest extends FormRequest
{
    public function rules()
    {
        $baseRules = [
            'job_title' => 'required|string',
            'tos_accepted' => 'accepted'
        ];

        return null !== $this->get('user')
            ? (new StoreUserRequest())->rules() + $baseRules
            : $baseRules;
    }
}
