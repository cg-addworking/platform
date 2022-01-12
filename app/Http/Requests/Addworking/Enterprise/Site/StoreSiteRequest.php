<?php

namespace App\Http\Requests\Addworking\Enterprise\Site;

use App\Models\Addworking\Enterprise\Site;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSiteRequest extends FormRequest
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
            'site.display_name'  => "required|string|max:255",
            'site.analytic_code' => "nullable|string",
            'address'            => "required|array",

            'phone_number'       => "required|array|min:1",

        ];
    }
}
