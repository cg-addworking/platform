<?php

namespace Components\Enterprise\WorkField\Application\Requests;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkFieldRequest extends FormRequest
{
    public function rules()
    {
        $enterprise = (new Enterprise)->getTable();

        return [
            'work_field.enterprise' => "sometimes|uuid|exists:{$enterprise},id",
            'work_field.display_name' => "required|max:255",
            'work_field.description' => "nullable",
            'work_field.started_at' => "nullable|date",
            'work_field.ended_at' => "nullable|date|after_or_equal:contract.started_at",
            'work_field.estimated_budget' => "nullable|numeric",
        ];
    }
}
