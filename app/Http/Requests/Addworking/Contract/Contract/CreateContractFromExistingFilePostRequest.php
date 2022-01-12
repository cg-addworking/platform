<?php

namespace App\Http\Requests\Addworking\Contract\Contract;

use App\Http\Requests\Addworking\Contract\Contract\CreateBlankContractRequest;
use App\Models\Addworking\Contract\Contract;
use Illuminate\Foundation\Http\FormRequest;

class CreateContractFromExistingFilePostRequest extends CreateBlankContractRequest
{
    public function authorize()
    {
        return $this->user()->can('createFromExistingFile', [Contract::class, $this->route('enterprise')]);
    }

    public function rules()
    {
        return parent::rules() + [
            'contract.file'        => "required|file|mimes:pdf|max:4000|min:1",
        ];
    }

    public function messages()
    {
        return parent::messages() + [
            'contract.file.file' => "Vous devez fournir un fichier valide",
        ];
    }
}
