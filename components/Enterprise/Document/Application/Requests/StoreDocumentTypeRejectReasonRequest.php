<?php

namespace Components\Enterprise\Document\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentTypeRejectReasonRequest extends FormRequest
{
    public function rules()
    {
        return [
            'document_type_reject_reason.display_name' => "required|string",
            'document_type_reject_reason.message' => "required|string",
            'document_type_reject_reason.is_univesal' => "nullable",
        ];
    }
}
