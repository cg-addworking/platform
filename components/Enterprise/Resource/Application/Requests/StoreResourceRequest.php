<?php

namespace Components\Enterprise\Resource\Application\Requests;

use App\Support\Facades\Repository;
use Illuminate\Foundation\Http\FormRequest;

class StoreResourceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $statuses = implode(',', Repository::resource()->getAvailableStatuses());

        return [
            'resource.first_name'          => "nullable|max:255",
            'resource.last_name'           => "nullable|max:255",
            'resource.email'               => "required|email",
            'resource.registration_number' => "nullable|max:255",
            'resource.status'              => "required|string|max:255|in:{$statuses}",
            'resource.note'                => "nullable",
            'resource.file'                 => 'nullable|file|min:1|mimes:pdf|max:4000',
            'resource.activity_period.customer_id' => 'required|uuid',
            'resource.activity_period.starts_at' => 'required|date',
            'resource.activity_period.ends_at' => 'nullable|date',
        ];
    }
}
