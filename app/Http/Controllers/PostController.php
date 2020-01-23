<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use \App\User;
use \App\Post;
use \App\Like;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Post $post)
    {
        /* find out if user liked post */
        $liked = Like::where("user_id", Auth::user()->id)->where("post_id", $post->id)->get();
        $liked = isset($liked[0]) ? 1 : 0;

        $result = $this->countLikers($post);
        $likers = $result[0];
        $others = $result[1];

        /* get auth user username */
        $username = Auth::user()->username;

        return view('post.show', compact('post', 'liked', 'likers', 'others'));
    }

    public function likers(Request $request)
    {
        $postId = $request->segment(2);
        $post = Post::find($postId);
        return $this->countLikers($post);
    }

    public function countLikers(Post $post)
    {
        /* count likes */
        $likesCount = $post->likes()->count();

        /* find likers */
        $likers = '';
        $others = 0;
        if ($likesCount > 0) {
            for ($i = 0; $i < $likesCount; $i++) {
                $username = $post->likes[$i]->user->username;
                if ($i === $likesCount - 1) {
                    $likers .= $username;
                    break;
                } elseif ($i === 2) {
                    $likers .= $username;
                    break;
                } else {
                    $likers .= "$username, ";
                }
            }
            if ($likesCount > 3) {
                $others = $likesCount - 3;
            }
        }

        return [$likers, $others];
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            "caption" => ["nullable", "string"],
            "image" => ["required", "image"]
        ]);

        $imgPath = $validatedData['image']->store('uploads', 'public');
        $image = Image::make(public_path("storage/{$imgPath}"))->fit(1000, 1000);
        $image->save();

        $user->posts()->create(
            array_merge($validatedData, ["image" => $imgPath])
        );

        return redirect("/profiles/$id");
    }
}
