<?php

namespace App\Http\Requests\Addworking\Enterprise\Document;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentProofAuthenticityRequest extends FormRequest
{
    public function rules()
    {
        return [
            'proof_authenticity_file' => 'required|file',
        ];
    }
}
