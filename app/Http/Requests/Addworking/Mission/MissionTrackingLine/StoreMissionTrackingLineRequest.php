<?php

namespace App\Http\Requests\Addworking\Mission\MissionTrackingLine;

use App\Models\Addworking\Mission\MissionTrackingLine;
use Illuminate\Foundation\Http\FormRequest;

class StoreMissionTrackingLineRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'line.label'            => 'nullable|string',
            'line.quantity'         => 'required|numeric',
            'line.unit'             => 'required|string',
            'line.unit_price'       => 'required|numeric',
        ];
    }
}
