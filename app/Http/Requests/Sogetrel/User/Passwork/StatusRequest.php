<?php

namespace App\Http\Requests\Sogetrel\User\Passwork;

use App\Models\Sogetrel\User\Passwork;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StatusPasswork
 * @package App\Http\Requests\Sogetrel\User\Passwork
 */
class StatusRequest extends FormRequest
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
            'status' => [
                'required',
                'string',
                Rule::in(Passwork::getAvailableStatuses()),
            ],
        ];

        if ($this->input('status') === Passwork::STATUS_ACCEPTED) {
            $rules += [
                'contract_types' => 'required|array',
                'work_starts_at' => 'required|date',
                'date_due_at' => 'required|date',
                'administrative_manager' => 'required|uuid|exists:addworking_user_users,id',
                'administrative_assistant' => 'required|uuid|exists:addworking_user_users,id',
                'operational_manager' => 'required|uuid|exists:addworking_user_users,id',
                'contract_signatory' => 'required|uuid|exists:addworking_user_users,id',
                'applicable_price_slip' => 'required|max:255',
                'needs_decennial_insurance' => 'required'
            ];

            if (! is_numeric($this->input('bank_guarantee_amount'))) {
                $rules['bank_guarantee_amount'] = ['required', Rule::in(['nc', 'NC', 'Nc', 'nC'])];
            } else {
                $rules['bank_guarantee_amount'] = 'required|numeric';
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'bank_guarantee_amount.*' =>
                __('sogetrel_passwork::acceptation._form.bank_guarantee_amount_required'),
        ];
    }
}
