<?php

namespace App\Http\Requests\Sogetrel\User\Quizz;

use App\Models\Sogetrel\User\Quizz;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'quizz.status'       => ["required", Rule::in(Quizz::getAvailableStatuses())],
            'quizz.job'          => "required|string",
            'quizz.score'        => "numeric|between:0,20",
            'quizz.proposed_at'  => "date",
            'quizz.completed_at' => "date",
        ];
    }
}
