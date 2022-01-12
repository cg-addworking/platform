<?php

namespace App\Http\Requests\Addworking\Enterprise\LegalForm;

use App\Models\Addworking\Enterprise\LegalForm;
use Illuminate\Foundation\Http\FormRequest;

class StoreLegalFormRequest extends FormRequest
{
    public function rules()
    {
        $table = (new LegalForm)->getTable();

        return [
            'legal_form.name'         => "required|string|max:255|unique:{$table},name",
            'legal_form.display_name' => "required|string|max:255",
            'legal_form.country'      => "required|string|max:2",
        ];
    }
}
