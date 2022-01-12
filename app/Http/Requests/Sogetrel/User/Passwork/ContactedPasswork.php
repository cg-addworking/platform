<?php

namespace App\Http\Requests\Sogetrel\User\Passwork;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ContactedPasswork
 * @package App\Http\Requests\Sogetrel\User\Passwork
 */
class ContactedPasswork extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'flag_contacted' => "required|bool",
        ];
    }
}
