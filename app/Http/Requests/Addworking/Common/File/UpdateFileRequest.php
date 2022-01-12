<?php

namespace App\Http\Requests\Addworking\Common\File;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $file = $this->route()->parameter('file');

        return [
            'file.content'          => 'nullable|file|min:1|mimes:pdf,csv,jpg,png,txt|max:4000',
            'file.path'             => 'string|' . Rule::unique('addworking_common_files', 'path')->ignore($file),
            'file.mime_type'        => 'string|' . Rule::in(array_flatten(config('mime-type'))),
            'file.return-to'        => 'nullable',
        ];
    }
}
