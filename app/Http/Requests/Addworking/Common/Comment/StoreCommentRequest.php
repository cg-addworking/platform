<?php

namespace App\Http\Requests\Addworking\Common\Comment;

use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', Comment::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user_table = (new User)->getTable();

        return [
            "comment.content"          => "required|string",
            "comment.commentable_id"   => "required|uuid",
            "comment.commentable_type" => "required|string",
            "comment.visibility"       => "required",
            "comment.users_to_notify." => "nullable|uuid|exists:{$user_table},id",
        ];
    }
}
