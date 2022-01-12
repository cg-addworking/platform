<?php

namespace App\Http\Requests\Addworking\Enterprise\Member;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Rules\CanSendInvitation;
use Illuminate\Foundation\Http\FormRequest;

class StoreEnterpriseMemberInvitationRequest extends FormRequest
{
    public function rules()
    {
        /** @var Enterprise $enterprise */
        $enterprise = $this->route('enterprise');

        return [
            'email'            => [
                'required',
                'email',
                new CanSendInvitation($enterprise),
                function ($attribute, $value, $fail) use ($enterprise) {
                    if ($enterprise->users()->get()->where('email', $value)->isNotEmpty()) {
                        $fail("Cet utilisateur est déjà membre de l'entreprise");
                    }
                }
            ],
            'member.roles'     => 'required|array',
            'member.accesses'  => 'array',
        ];
    }
}
