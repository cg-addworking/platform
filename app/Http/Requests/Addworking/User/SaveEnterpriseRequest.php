<?php

namespace App\Http\Requests\Addworking\User;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveEnterpriseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Todo: check if user has permission to save enterprise
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->enterpriseRules() +
            $this->addressRules() +
            $this->phoneNumberRules() +
            $this->enterpriseActivityRules() +
            $this->signatoryRule();
    }

    /**
     * @return array
     */
    protected function enterpriseRules()
    {
        return [
            'enterprise.legal_form_id' => 'required|uuid|exists:addworking_enterprise_legal_forms,id',
            'enterprise.name' => 'required|string|max:255|' . Rule::unique('addworking_enterprise_enterprises', 'name'),
            'enterprise.identification_number' => [
                'nullable',
                'required_without:enterprise.structure_in_creation',
                'max:255',
                'regex:/^\\d{14}$/',
                Rule::unique('addworking_enterprise_enterprises', 'identification_number'),
            ],
            'enterprise.tax_identification_number' => [
                'nullable',
                'required_without:enterprise.structure_in_creation',
                'max:14',
                'regex:/^[a-zA-Z]{2}?[0-9]{11}+$/',
            ],
            'enterprise.registration_town' => 'required|string|max:255',
        ];
    }

    /**
     * @return array
     */
    protected function addressRules()
    {
        return [
            'address.address' => 'required|string|max:255',
            'address.additionnal_address' => 'nullable|string|max:255',
            'address.town' => 'required|string|max:255',
            'address.zipcode' => 'required|numeric',
            'address.country' => 'required|string|max:2',
        ];
    }

    /**
     * @return array
     */
    protected function phoneNumberRules()
    {
        return [
            'phones.primary' => 'required_without:phones.secondary|nullable|french_phone_number',
            'phones.secondary' => 'required_without:phones.primary|nullable|french_phone_number',
        ];
    }

    /**
     * @return array
     */
    protected function enterpriseActivityRules()
    {
        return [
            'enterprise_activity.activity' => 'required|string|max:255',
            'enterprise_activity.field' => 'required|string|max:255',
            'enterprise_activity.employees_count' => 'required|numeric|min:0',
            'enterprise_activity.region' => 'required|string|max:255',
        ];
    }

    /**
     * @return array
     */
    protected function signatoryRule()
    {
        return [
            'signatory.job_title' => 'required|string|max:255',
            'signatory.representative' => 'required|string|max:255',
        ];
    }
}
