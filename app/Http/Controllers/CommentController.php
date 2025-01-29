<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //fitur like comment
    public function likeComment (Comment $comment, Request $request) {

        // fitur like comment menambahkan komen id,user id, dan juga post id
        $comment->likedByUsers()->attach(Auth::user()->id,['post_id' => $comment->post_id]);
        return redirect()->back();
    }


    // fitur unlike comment
    public function unlikeComment (Comment $comment, Request $request) {
        $comment->likedByUsers()->detach(Auth::user()->id, ['post_id' => $comment->post_id]);
        return redirect()->back();
    }

    // fitur reply komen postingan
    public function replyComment (Comment $comment, Request $request) {

        $request->validate([
            'reply_comment' => ['required', 'string'],
        ], [
            'reply_comment.required' => 'Reply comment cannot be empty.',
        ]);
        $comment->replyComments()->create([
            'body' => $request->reply_comment,
            'user_id' => Auth::user()->id,
            'post_id' => $comment->post_id
        ]);

        return redirect()->back();
    }

}
