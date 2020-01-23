<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $postId = $request->segment(2);

        $query = Like::where("user_id", $user->id)->where("post_id", $postId);
        $result = $query->get();
        if (isset($result[0])) {
            /* user liked post -> delete */
            $query->delete();
        } else {
            /* user didn't like post -> add */
            $user->likes()->create(["post_id" => $postId]);
        }
    }
}
