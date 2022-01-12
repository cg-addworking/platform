<?php

namespace App\Http\Requests\Addworking\Enterprise;

use Illuminate\Foundation\Http\FormRequest;

class SaveEnterpriseSignatoryRequest extends FormRequest
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
            'enterprise.id'            => 'required|uuid|exists:addworking_enterprise_enterprises,id',
            'signatory.id'             => 'required|uuid|exists:addworking_user_users,id',
            'signatory.job_title'      => 'required|string|max:255',
            'signatory.representative' => 'string|max:255',
        ];
    }
}
