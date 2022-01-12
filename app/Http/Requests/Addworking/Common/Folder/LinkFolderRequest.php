<?php

namespace App\Http\Requests\Addworking\Common\Folder;

use App\Models\Addworking\Common\Folder;
use Illuminate\Foundation\Http\FormRequest;

class LinkFolderRequest extends FormRequest
{
    public function rules()
    {
        $table = (new Folder)->getTable();

        return [
            'folder.id' => "required|uuid|exists:$table,id",
            'item.id'   => "required|uuid",
        ];
    }
}
