<?php

namespace App\Http\Requests\Addworking\Common\Passwork;

use App\Models\Addworking\Common\Passwork;
use Illuminate\Foundation\Http\FormRequest;

class StorePassworkRequest extends FormRequest
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
            'customer.id' => "required|uuid||exists:addworking_enterprise_enterprises,id",
        ];
    }
}
