<?php

namespace App\Http\Requests\Addworking\Enterprise\Document;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Rules\IsJsonFile;
use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize()
    {
        $enterprise    = $this->route('enterprise');
        $document_type = DocumentType::findOrFail($this->document_type);

        return $this->user()->can('create', [Document::class, $enterprise, $document_type]);
    }

    public function rules()
    {
        $document_type = DocumentType::findOrFail($this->document_type);

        if ($this->input('document.choice') == 'file') {
            $rules = [
                'document_files'       => ['required', 'array', 'max:10'],
                'document.valid_from'  => 'required|regex:/^\d{4}-\d{2}-\d{2}$/',
                'document.valid_until' => 'nullable|regex:/^\d{4}-\d{2}-\d{2}$/',
            ];

            foreach ($document_type->documentTypeFields as $field) {
                $rules += $field->validation_rule;
            }

            if (!$this->hasFile('document_files')) {
                $rules['document_files'][] = new IsJsonFile();
            }

            return $rules;
        }

        return [];
    }
}
