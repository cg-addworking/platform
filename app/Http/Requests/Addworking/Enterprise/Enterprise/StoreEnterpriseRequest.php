<?php

namespace App\Http\Requests\Addworking\Enterprise\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Common\Common\Domain\Interfaces\Entities\CountryEntityInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEnterpriseRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('store', Enterprise::class);
    }

    public function prepareForValidation()
    {
        $this->merge([
            'enterprise' => [
                'name' => Enterprise::sanitizeName($this->input('enterprise.name')),
            ] + $this->input('enterprise'),
        ]);
    }


    public function rules()
    {
        $table = (new Enterprise)->getTable();

        return [
            'enterprise.legal_form_id' => 'required|uuid|exists:addworking_enterprise_legal_forms,id',
            'enterprise.name' => [
                "required",
                "string",
                "max:255",
            ],
            'enterprise.structure_in_creation' => "boolean",
            'enterprise.main_activity_code' => "regex:/^[0-9]{4}?[a-zA-Z]{1}+$/",
            'enterprise.tax_identification_number' =>
                $this->input('enterprise.country') === CountryEntityInterface::CODE_DEUTSCHLAND
                    ? "required|regex:/^(DE).*/|unique:{$table},tax_identification_number"
                    : "nullable|regex:/^[a-zA-Z]{2}?[0-9]{11}+$/|unique:{$table},tax_identification_number",
            'enterprise.registration_town' => "required|string|max:255",
            'enterprise.registration_date' =>
                $this->input('enterprise.country') === CountryEntityInterface::CODE_DEUTSCHLAND
                    ? "required|date" : '',
            'phone_number.1.number' => "required|phone:FR,BE,DE",
            'phone_number.2.number' => "nullable|phone:FR,BE,DE",
            'phone_number.3.number' => "nullable|phone:FR,BE,DE",

            'enterprise.identification_number' =>
                $this->input('enterprise.country') === CountryEntityInterface::CODE_DEUTSCHLAND ?
                [
                    "unique:{$table},identification_number",
                    "regex:/^(HRB|HRA).*/",
                ] : [
                    "nullable",
                    "unique:{$table},identification_number",
                    "required_without:enterprise.structure_in_creation",
                    $this->input('enterprise.country') === CountryEntityInterface::CODE_FRANCE ? "min:14" : '',
                    $this->input('enterprise.country') === CountryEntityInterface::CODE_FRANCE ? "max:14" : '',
                    $this->input('enterprise.country') === CountryEntityInterface::CODE_FRANCE ? "string" : '',
                    $this->input('enterprise.country') === CountryEntityInterface::CODE_FRANCE ?
                        "regex:/^[0-9]+$/" : '',
                ],

            'enterprise_activity.field' =>
                $this->input('enterprise.country') === CountryEntityInterface::CODE_FRANCE ? 'required' : '',
            'member.job_title' => "required",
            'enterprise.sectors' => "nullable",
        ];
    }

    public function messages()
    {
        return [
            'enterprise.identification_number.unique' =>
                __('addworking.enterprise.enterprise.requests.store_enterprise_request.messages.unique'),
        ];
    }
}
