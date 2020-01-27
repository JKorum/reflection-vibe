<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Post;
use \App\User;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function delete(Request $request, Post $post)
    {
        $user = Auth::user();
        if ($user->id == $post->user_id) {
            /* user is post owner */
            $commentId = $request->segment(4);
            $post->comments()->where('id', $commentId)->delete();
            return $this->buildComments($post);
        }

        return null;
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $postId = $request->segment(2);
        $comment = $request->input('comment');
        $post = Post::find($postId);
        $post->commentAsUser($user, $comment);

        return $this->buildComments($post);
    }

    public function show(Request $request)
    {
        $postId = $request->segment(2);
        $post = Post::find($postId);

        return $this->buildComments($post);
    }

    public function buildComments(Post $post)
    {
        $comments = [];
        foreach ($post->comments as $comment) {
            $user = User::find($comment->user_id);
            if (isset($user)) {
                $comments[] = [
                    "id" => $comment->id,
                    "username" => $user->username,
                    "avatar" => $user->profile->getAvatar(),
                    "comment" => $comment->comment,
                    "created_at" => $comment->created_at
                ];
            }
        }

        return $comments;
    }
}
