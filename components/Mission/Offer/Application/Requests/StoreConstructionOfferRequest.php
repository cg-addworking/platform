<?php

namespace Components\Mission\Offer\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConstructionOfferRequest extends FormRequest
{
    public function rules()
    {
        return [
            'offer.enterprise_id' => 'sometimes|uuid|exists:addworking_enterprise_enterprises,id',
            'offer.referent_id' => 'required|uuid|exists:addworking_user_users,id',
            'offer.workfield_id' => 'nullable|uuid|exists:addworking_enterprise_work_fields,id',
            'offer.label' => 'required|string|max:255',
            'offer.starts_at_desired' => 'required|date',
            'offer.ends_at' => 'nullable|date|after_or_equal:offer.starts_at_desired',
            'offer.description' => 'required|string',
            'offer.external_id' => 'nullable|string|max:255',
            'offer.analytic_code' => 'nullable|string|max:255',
            'offer.file.' => 'nullable|file|mimes:pdf,zip|max:128000|min:1',
        ];
    }
}
