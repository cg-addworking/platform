<?php

namespace App\Http\Requests\Addworking\Mission\Mission;

use App\Models\Addworking\Mission\Mission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Mission::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vendor.id'              => 'nullable|uuid|exists:addworking_enterprise_enterprises,id',
            'customer.id'            => 'uuid|exists:addworking_enterprise_enterprises,id',
            'mission.label'          => 'required|string|max:255',
            'mission.location'       => 'string|max:255',
            'mission.external_id'    => 'nullable|string|max:255',
            'mission.description'    => 'string',
            'mission.starts_at'      => 'required|date',
            'mission.ends_at'        => 'required_if:mission.milestone_type,end_of_mission
                |after_or_equal:mission.starts_at',
            'mission.milestone_type' => 'required',
            'mission.unit'           => ['nullable', Rule::in(Mission::getAvailableUnits())],
            'mission.unit_price'     => 'nullable|numeric',
            'mission.quantity'       => 'nullable|numeric|min:1',
        ];
    }
}
