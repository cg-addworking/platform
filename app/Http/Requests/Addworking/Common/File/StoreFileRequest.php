<?php

namespace App\Http\Requests\Addworking\Common\File;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Addworking\Common\File;

class StoreFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', File::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file.content'          => 'file|min:1|max:4000|mimes:pdf,csv,jpg,png,txt',
            'file.attachable_id'    => 'nullable|uuid',
            'file.attachable_type'  => 'nullable|string',
            'file.return-to'        => 'nullable',
        ];
    }
}
