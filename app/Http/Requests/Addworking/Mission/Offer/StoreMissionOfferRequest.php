<?php

namespace App\Http\Requests\Addworking\Mission\Offer;

use App\Models\Addworking\Mission\Offer;
use Illuminate\Foundation\Http\FormRequest;

class StoreMissionOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', Offer::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer.id'                     => 'required|uuid|exists:addworking_enterprise_enterprises,id',
            'department.id'                   => 'nullable|exists:addworking_common_departments,id',
            'mission_offer.external_id'       => 'nullable|string|max:255',
            'mission_offer.description'       => 'required|string',
            'mission_offer.starts_at_desired' => 'required|date',
            'mission_offer.ends_at'           => 'nullable|date|after_or_equal:mission_offer.starts_at_desired',
            'mission_offer.file.'             => 'nullable|file|mimes:pdf|max:4000|min:1',
            'mission_offer.skills'            => 'nullable|array|exists:addworking_common_skills,id',
        ];
    }
}
