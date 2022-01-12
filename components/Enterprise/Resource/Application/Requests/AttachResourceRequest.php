<?php

namespace Components\Enterprise\Resource\Application\Requests;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Http\FormRequest;

class AttachResourceRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()
            && $this->user()->can('attach', $this->route('resource'));
    }

    public function rules()
    {

        return [
            'file.content'                 => 'required|file|min:1|mimes:pdf|max:4000',
        ];
    }
}
