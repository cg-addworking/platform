<?php

namespace App\Http\Requests\Addworking\Mission\Proposal;

use App\Models\Addworking\Mission\Proposal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'mission_proposal.label'              => "nullable|string|max:255",
            'mission_proposal.external_id'        => "nullable|string|max:255",
            'mission_proposal.valid_from'         => "required",
            'mission_proposal.valid_until'        => "nullable",
            'mission_proposal.need_quotation'     => "required|boolean",
            'mission_proposal.unit'               => ['nullable', Rule::in(Proposal::getAvailableUnits())],
            'mission_proposal.quantity'           => 'nullable|numeric|min:1',
            'mission_proposal.unit_price'         => 'nullable|numeric',
            'mission_proposal.details'            => 'nullable|string'
        ];
    }
}
