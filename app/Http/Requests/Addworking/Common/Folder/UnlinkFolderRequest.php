<?php

namespace App\Http\Requests\Addworking\Common\Folder;

use Illuminate\Foundation\Http\FormRequest;

class UnlinkFolderRequest extends FormRequest
{
    public function rules()
    {
        return (new LinkFolderRequest)->rules();
    }
}
