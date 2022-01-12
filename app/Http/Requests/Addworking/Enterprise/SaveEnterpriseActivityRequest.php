<?php

namespace App\Http\Requests\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\EnterpriseActivity;
use Illuminate\Foundation\Http\FormRequest;

class SaveEnterpriseActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', EnterpriseActivity::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'enterprise.id' => 'required|uuid|exists:addworking_enterprise_enterprises,id',
            'enterprise_activity.id' => 'uuid|exists:addworking_enterprise_activities,id',
            'enterprise_activity.activity' => 'required|string|max:255',
            'enterprise_activity.field' => 'required|string|max:255',
            'enterprise_activity.employees_count' => 'required|numeric|min:0',
            'enterprise_activity.region' => 'required|string|max:255',
        ];
    }
}
