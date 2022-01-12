<?php

namespace App\Http\Controllers\Addworking;

use App\Models\Addworking\Common\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(501);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        abort(501);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(501);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('store', Comment::class);

        $request->validate([
            "comment.content"           => "required|string",
            "comment.commentable_id"    => "required|uuid",
            "comment.commentable_type"  => "required|string",
        ]);

        $model = "App\Models\Addworking\\" . $request->input('comment.commentable_type');

        $comment = new Comment;
        $comment->fill($request->input('comment'));
        $comment->commentable_type = $model;
        $comment->author()->associate(Auth::user());

        $saved = transaction(function () use ($comment) {
            if (!$comment->save()) {
                return false;
            }
        });

        return $saved
            ? redirect()->back()->with(success_status(
                __('messages.comment.save_success')
            ))
            :  redirect()->back()->with(error_status(
                __('messages.comment.save_failed')
            ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        abort(501);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        abort(501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('destroy', $comment);

        $deleted = $comment->delete();

        return $deleted
            ? redirect()->back()->with(success_status(
                __('messages.comment.delete_success')
            ))
            : redirect()->back()->with(error_status(
                __('messages.comment.delete_failed')
            ));
    }
}
