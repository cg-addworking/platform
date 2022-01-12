<?php

namespace App\Http\Requests\Addworking\Common\Passwork;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassworkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', [
            $this->route()->parameter('passwork'),
            $this->route()->parameter('enterprise')
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
