<?php

namespace App\Http\Requests\Everial\Mission\Referential;

use App\Models\Everial\Mission\Referential;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReferentialRequest extends FormRequest
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
            'referential.shipping_site'       => "required|string",
            'referential.shipping_address'    => "required|string",
            'referential.destination_site'    => "required|string",
            'referential.destination_address' => "required|string",
            'referential.distance'            => "required|numeric",
            'referential.pallet_number'       => "required|numeric|min:1",
            'referential.pallet_type'         => "required|string",
            'referential.analytic_code'       => "nullable|string",
            'referential.best_bidder'         => "nullable|uuid|exists:addworking_enterprise_enterprises,id"
        ];
    }
}
