<?php

namespace App\Http\Requests\Addworking;

use App\Models\Addworking\Common\Address;
use Illuminate\Foundation\Http\FormRequest;

class SaveAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', Address::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'enterprise.id' => 'uuid|exists:addworking_enterprise_enterprises,id',
            'address.id' => 'uuid|exists:addresses,id',
            'address.address' => 'required|string|max:255',
            'address.additionnal_address' => 'nullable|string|max:255',
            'address.town' => 'required|string|max:255',
            'address.zipcode' => 'required|numeric',
            'address.country' => 'required|string|max:2',
        ];
    }
}
