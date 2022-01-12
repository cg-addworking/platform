<?php

namespace App\Http\Requests\Addworking\Contract\Contract;

use App\Http\Requests\Addworking\Contract\Contract\CreateContractFromExistingFilePostRequest;
use App\Models\Addworking\Contract\ContractAddendum;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractAddendumRequest extends CreateContractFromExistingFilePostRequest
{
    public function authorize()
    {
        return $this->user()
            && $this->user()->can('createAddendum', $this->route('contract'));
    }
}
