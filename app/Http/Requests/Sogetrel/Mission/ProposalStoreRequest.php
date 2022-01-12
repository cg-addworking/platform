<?php

namespace App\Http\Requests\Sogetrel\Mission;

use App\Models\Addworking\Mission\Proposal;
use Illuminate\Foundation\Http\FormRequest;

class ProposalStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', Proposal::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mission_offer.id'                    => "required|uuid||exists:addworking_mission_offers,id",
            'vendor.id'                           => "required|array",
            'vendor.id.*'                         => "required|uuid",
            'mission_proposal.label'              => "nullable|string|max:255",
            'mission_proposal.external_id'        => "nullable|string|max:255",
            'mission_proposal.valid_from'         => "required|date_format:d/m/Y",
            'mission_proposal.valid_until'        => "nullable|date_format:d/m/Y",
            'mission_proposal.need_quotation'     => "required|boolean",
            'mission_proposal.unit'               => "nullable|string",
            'mission_proposal.quantity'           => 'nullable|numeric|min:1',
            'mission_proposal.unit_price'         => 'nullable|numeric',
            'mission_proposal.details'            => 'nullable|string'
        ];
    }
}
