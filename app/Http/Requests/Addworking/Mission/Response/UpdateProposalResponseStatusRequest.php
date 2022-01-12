<?php

namespace App\Http\Requests\Addworking\Mission\Response;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Addworking\Mission\ProposalResponse;
use Illuminate\Validation\Rule;

class UpdateProposalResponseStatusRequest extends FormRequest
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
            'response.status' => Rule::in(ProposalResponse::getAvailableStatuses()),
        ];
    }
}
