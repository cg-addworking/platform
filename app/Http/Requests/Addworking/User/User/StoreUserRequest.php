<?php

namespace App\Http\Requests\Addworking\User\User;

use App\Models\Addworking\User\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', User::class);
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
            'user.email'            =>  "required|email|unique:addworking_user_users,email",
            'user.password'         =>  "required|string|min:6|max:255",
            'user.password_confirm' =>  "required|string|min:6|max:255|same:user.password",
            'user.phone_number'     =>  "required|phone:FR,BE,DE",
        ];
    }
}
