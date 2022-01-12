<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WysiwygPreviewRequest extends FormRequest
{
    public function rules()
    {
        return [
            'content' => "required",
        ];
    }
}
