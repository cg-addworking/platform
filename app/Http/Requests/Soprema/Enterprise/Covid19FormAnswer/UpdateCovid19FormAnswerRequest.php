<?php

namespace App\Http\Requests\Soprema\Enterprise\Covid19FormAnswer;

use App\Models\Soprema\Enterprise\Covid19FormAnswer;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCovid19FormAnswerRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('covid19_form_answer'));
    }

    public function rules()
    {
        $rules = (new StoreCovid19FormAnswerRequest)->rules();
        $table = (new Covid19FormAnswer)->getTable();

        return $rules + [
            'covid19_form_answer.id' => "required|uuid|exists:{$table},id",
        ];
    }
}
