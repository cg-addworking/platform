<?php

namespace App\Http\Requests\Addworking\Enterprise\Document;

use Illuminate\Foundation\Http\FormRequest;

class StoreAcceptDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('accept', $this->route('document'));
    }

    public function rules()
    {
        return [
            'document.valid_until' => "required|date",
        ];
    }
}
