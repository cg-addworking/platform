<?php

namespace Components\Enterprise\Resource\Application\Requests;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Http\FormRequest;

class AssignResourceRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()
            && $this->user()->can('assign', $this->route('resource'));
    }

    public function rules()
    {
        $enterprise = (new Enterprise)->getTable();

        return [
            'activity_period.customer_id' => "required|uuid|exists:{$enterprise},id",
            'activity_period.starts_at' => "required|date",
            'activity_period.ends_at' => "nullable|date"
        ];
    }
}
