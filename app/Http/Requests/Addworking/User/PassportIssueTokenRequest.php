<?php

namespace App\Http\Requests\Addworking\User;

use Illuminate\Foundation\Http\FormRequest;

class PassportIssueTokenRequest extends FormRequest
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
            'client_id' => 'required|integer',
            'client_secret' => 'required',
        ];
    }
}
