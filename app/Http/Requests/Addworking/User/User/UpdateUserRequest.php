<?php

namespace App\Http\Requests\Addworking\User\User;

use App\Models\Addworking\User\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user.gender'           => ["required", Rule::in(User::getAvailableGenders())],
            'user.firstname'        =>  "required|string|max:255",
            'user.lastname'         =>  "required|string|max:255",
            'user.phone_number'     =>  "required|phone:FR,BE,DE",
        ];
    }
}
