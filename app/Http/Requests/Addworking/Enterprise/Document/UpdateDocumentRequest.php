<?php

namespace App\Http\Requests\Addworking\Enterprise\Document;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('document'));
    }

    public function rules()
    {
        if ($this->ajax()) {
            return [
                'document.valid_from'           => "nullable|date",
                'document.valid_until'          => "nullable|date",
            ];
        }

        $document_table    = (new Document)->getTable();
        $user_table        = (new User)->getTable();

        $statuses          = implode(',', Document::getAvailableStatuses());

        $rules = [
            'document.id'                   => "uuid|exists:$document_table,id",
            'document.status'               => "string|in:$statuses",
            'document.reason_for_rejection' => 'nullable|uuid|exists:addworking_enterprise_document_reject_reasons,id',
            'document.valid_from'           => "nullable|date",
            'document.valid_until'          => "nullable|date",
            'document.accepted_by'          => "nullable|uuid|exists:$user_table,id",
            'document.accepted_at'          => "nullable|date",
            'document.rejected_by'          => "nullable|uuid|exists:$user_table,id",
            'document.rejected_at'          => "nullable|date",
        ];

        foreach ($this->route('document')->documentType->documentTypeFields as $field) {
            $rules += $field->validation_rule;
        }

        return $rules;
    }
}
