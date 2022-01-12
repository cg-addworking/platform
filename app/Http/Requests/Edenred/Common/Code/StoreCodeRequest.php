<?php

namespace App\Http\Requests\Edenred\Common\Code;

use App\Models\Edenred\Common\Code;
use Illuminate\Foundation\Http\FormRequest;

class StoreCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Code::class);
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
