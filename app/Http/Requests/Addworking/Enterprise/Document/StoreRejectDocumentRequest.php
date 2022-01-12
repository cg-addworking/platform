<?php

namespace App\Http\Requests\Addworking\Enterprise\Document;

use Illuminate\Foundation\Http\FormRequest;

class StoreRejectDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('reject', $this->route('document'));
    }

    public function rules()
    {
        return [
            'document.reason_for_rejection' => 'required|uuid|exists:addworking_enterprise_document_reject_reasons,id',
        ];
    }
}
