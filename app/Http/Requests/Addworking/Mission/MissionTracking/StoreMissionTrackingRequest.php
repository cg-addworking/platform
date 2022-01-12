<?php

namespace App\Http\Requests\Addworking\Mission\MissionTracking;

use App\Models\Addworking\Mission\MissionTracking;
use Illuminate\Foundation\Http\FormRequest;

class StoreMissionTrackingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', MissionTracking::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'milestone.id'          => 'required|uuid|exists:addworking_mission_milestones,id',
            'tracking.description'  => 'nullable|string',
            'line.label'            => 'required|string|max:255',
        ];
    }
}
