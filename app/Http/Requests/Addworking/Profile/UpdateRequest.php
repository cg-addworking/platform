<?php

namespace App\Http\Requests\Addworking\Profile;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'gender' => ['required', Rule::in(['male', 'female'])],
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'picture' => 'nullable|mimes:jpeg,jpg,png|max:1500'
        ];
    }
}
