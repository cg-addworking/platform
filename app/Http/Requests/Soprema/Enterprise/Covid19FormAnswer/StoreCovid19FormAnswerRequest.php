<?php

namespace App\Http\Requests\Soprema\Enterprise\Covid19FormAnswer;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Soprema\Enterprise\Covid19FormAnswer;
use Illuminate\Foundation\Http\FormRequest;

class StoreCovid19FormAnswerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $table = (new Enterprise)->getTable();

        return [
            'covid19_form_answer.vendor_id'    => "nullable|uuid|exists:{$table},id",
            'covid19_form_answer.customer_id'  => "nullable|uuid|exists:{$table},id",
            'covid19_form_answer.vendor_name'  => "required|string|max:255",
            'covid19_form_answer.vendor_siret' => "required|string|regex:/^([a-zA-Z]{2})?[0-9]{14}$/",
            'covid19_form_answer.pursuit'      => "required|boolean",
            'covid19_form_answer.message'      => "required|string",
        ];
    }
}
