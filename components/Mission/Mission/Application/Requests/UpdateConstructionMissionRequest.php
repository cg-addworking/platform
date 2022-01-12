<?php

namespace Components\Mission\Mission\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConstructionMissionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'mission.referent_id' => 'required|uuid|exists:addworking_user_users,id',
            'mission.departments.*' => 'nullable|uuid|exists:addworking_common_departments,id',
            'mission.label' => 'required|string|max:255',
            'mission.starts_at' => 'required|date',
            'mission.ends_at' => 'nullable|date|after_or_equal:mission.starts_at',
            'mission.description' => 'required|string',
            'mission.external_id' => 'nullable|string|max:255',
            'mission.analytic_code' => 'nullable|string|max:255',
            'mission.file.*' => 'nullable|file|mimes:pdf,zip|max:128000|min:1',
            'mission.amount' => 'required|numeric',
        ];
    }
}
