<?php

namespace App\Http\Requests\Addworking\Enterprise\DocumentTypeField;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Addworking\Enterprise\DocumentTypeField;

class StoreDocumentTypeFieldRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('store', DocumentTypeField::class);
    }

    public function rules()
    {
        return [
            'field.type_id'      => 'required|uuid|exists:addworking_enterprise_document_types,id',
            'field.display_name' => 'required|string',
            'field.input_type'   => 'required|string',
            'field.help_text'    => 'nullable|string',
            'field.is_mandatory' => 'required|boolean',
        ];
    }
}
