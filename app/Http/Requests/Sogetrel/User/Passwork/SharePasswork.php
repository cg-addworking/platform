<?php

namespace App\Http\Requests\Sogetrel\User\Passwork;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Sogetrel\User\Passwork;

class SharePasswork extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('share', Passwork::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user'      => 'required|uuid|exists:addworking_user_users,id',
            'passwork'  => 'required|uuid|exists:sogetrel_user_passworks, id',
            'comment'   => "nullable"
        ];
    }
}
