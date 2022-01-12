<?php

namespace App\Http\Requests\Addworking\Mission\Response;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Addworking\Mission\ProposalResponse;

class UpdateProposalResponseRequest extends FormRequest
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
            'response.starts_at'    => 'required|date',
            'response.ends_at'      => 'nullable|date',
            'response.quantity'     => 'numeric',
            'response.valid_from'   => 'nullable|date',
            'response.valid_until'  => 'nullable|date|after_or_equal:response.valid_from',
            'response.unit'         => 'nullable|string',
            'response.unit_price'   => 'nullable|numeric',
        ];
    }
}
