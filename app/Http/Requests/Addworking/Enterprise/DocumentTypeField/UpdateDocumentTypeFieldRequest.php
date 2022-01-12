<?php

namespace App\Http\Requests\Addworking\Enterprise\DocumentTypeField;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Addworking\Enterprise\Document\DocumentTypeField;

class UpdateDocumentTypeFieldRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'field.display_name' => 'required|string',
            'field.input_type'   => 'required|string',
            'field.help_text'    => 'nullable|string',
            'field.is_mandatory' => 'required|boolean',
        ];
    }
}
