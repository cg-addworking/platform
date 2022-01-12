<?php

namespace Components\Contract\Contract\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadSignedContractRequest extends FormRequest
{
    public function rules()
    {
        return [
            'contract_party.signed_at.*' => "required|date",
            'contract_part.display_name' => "required|max:255",
            'contract_part.file'         => "required|file|mimes:pdf|max:15000|min:1"
        ];
    }
}
