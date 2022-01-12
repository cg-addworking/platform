<?php

namespace App\Http\Requests\Addworking\Mission\Proposal;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'mission_offer.id'                    => "required|uuid|exists:addworking_mission_offers,id",
            'vendor.id'                           => "required|array",
            'vendor.id.*'                         => "required|uuid",
            'mission_proposal.valid_from'         => "required",
            'mission_proposal.valid_until'        => "nullable",
            'mission_proposal.details'            => 'nullable|string'
        ];
    }
}
