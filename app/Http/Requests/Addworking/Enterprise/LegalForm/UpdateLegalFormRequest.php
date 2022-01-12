<?php

namespace App\Http\Requests\Addworking\Enterprise\LegalForm;

use App\Models\Addworking\Enterprise\LegalForm;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLegalFormRequest extends FormRequest
{
    public function rules()
    {
        return ['legal_form.display_name' => "required|string|max:255"];
    }
}
