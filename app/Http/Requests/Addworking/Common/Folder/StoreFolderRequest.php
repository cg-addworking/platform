<?php

namespace App\Http\Requests\Addworking\Common\Folder;

use App\Models\Addworking\Common\Folder;
use Illuminate\Foundation\Http\FormRequest;

class StoreFolderRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', [Folder::class, $this->route('enterprise')]);
    }

    public function rules()
    {
        return [
            'folder.display_name'        => "required|string|max:255",
            'folder.created_by'          => "required|uuid|exists:addworking_user_users,id",
            'folder.shared_with_vendors' => "boolean"
        ];
    }
}
