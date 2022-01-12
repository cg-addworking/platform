<?php

namespace Components\Enterprise\ActivityReport\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityReportRequest extends FormRequest
{
    public function rules()
    {
        return [
            'activity_report.year'  => "required|integer|date_format:Y",
            'activity_report.month' => "required|integer|date_format:m",
        ];
    }
}
