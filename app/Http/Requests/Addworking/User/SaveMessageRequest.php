<?php

namespace App\Http\Requests\Addworking\User;

use App\Models\Addworking\User\ChatMessage;
use Illuminate\Foundation\Http\FormRequest;

class SaveMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', ChatMessage::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message.user_id' => 'required',
            'message.message' => 'required_without:file.content|nullable',
            'message.name' => 'required',
            'message.receiver' => 'required',
            'file.content' => 'nullable|file|min:1|mimes:pdf|max:4000',
            'file.path' => 'required_without:file.content',
        ];
    }
}
