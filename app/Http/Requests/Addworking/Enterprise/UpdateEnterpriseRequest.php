<?php

namespace App\Http\Requests\Addworking\Enterprise;

use Components\Common\Common\Domain\Interfaces\Entities\CountryEntityInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Addworking\Enterprise\Enterprise;

class UpdateEnterpriseRequest extends FormRequest
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
        $rules = [
            'enterprise.logo' => 'file|mimes:jpeg,jpg,png|min:1|max:1500',
        ];

        if (auth()->user()->isSupport()) {
            $rules += [
                'enterprise.legal_form_id' => 'required|uuid|exists:addworking_enterprise_legal_forms,id',
                'enterprise.registration_town' => 'required|string|max:255',
                'enterprise.external_id' => 'nullable',
                'enterprise.name' => [
                    'required', 'string', 'max:255',
                ],
                'enterprise.identification_number' =>
                    $this->input('enterprise.country') === CountryEntityInterface::CODE_DEUTSCHLAND ?
                        [
                            "required",
                            "unique:addworking_enterprise_enterprises,identification_number,"
                            .$this->input('enterprise.id'),
                            "regex:/^(HRB|HRA).*/",
                        ] : [
                    'nullable',
                    'required_without:enterprise.structure_in_creation',
                    'regex:/^\d{14}$/',
                    'unique:addworking_enterprise_enterprises,identification_number,'
                    .$this->route('enterprise')->id,
                ],
                'enterprise.tax_identification_number' =>
                    $this->input('enterprise.country') === CountryEntityInterface::CODE_DEUTSCHLAND
                        ? "nullable|regex:/^(DE).*/" : '',
                'enterprise.registration_date' =>
                    $this->input('enterprise.country') === CountryEntityInterface::CODE_DEUTSCHLAND
                        ? "required|date" : '',
            ];
        }

        return $rules;
    }
}
