<?php

namespace App\Http\Requests\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEnterprisePhoneNumberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return ['phone_number.number' => "required|phone:FR,BE,DE",];
    }
}
