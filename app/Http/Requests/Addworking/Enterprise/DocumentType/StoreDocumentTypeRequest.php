<?php

namespace App\Http\Requests\Addworking\Enterprise\DocumentType;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Addworking\Enterprise\DocumentType;

class StoreDocumentTypeRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('store', DocumentType::class);
    }

    public function rules()
    {
        return [
            'type.display_name'    => 'required|string',
            'type.description'     => 'nullable|string',
            'type.is_mandatory'    => 'required|boolean',
            'type.validity_period' => 'nullable|numeric',
            'type.code'            => 'nullable|string',
            'type.type'            => 'required|string',
            'document_type.deadline_date' => 'nullable|string|date_format:d/m'
        ];
    }
}
