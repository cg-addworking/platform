<?php

namespace App\Http\Requests\Addworking\Enterprise\Iban;

use App\Models\Addworking\Enterprise\Iban;
use Illuminate\Foundation\Http\FormRequest;

class StoreIbanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', Iban::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'enterprise.id' => "required|uuid|exists:addworking_enterprise_enterprises,id",
            'iban.iban'     => 'iban',
            'iban.bic'      => 'nullable|bic',
            'file.content'  => 'required|file|min:1|mimes:pdf|max:4000',
        ];
    }
}
