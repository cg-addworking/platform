<?php

namespace App\Http\Requests\Addworking\Common\Folder;

use App\Models\Addworking\Common\Folder;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFolderRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('folder'));
    }

    public function rules()
    {
        return (new StoreFolderRequest)->rules();
    }
}
