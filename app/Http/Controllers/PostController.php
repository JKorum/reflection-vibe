<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use \App\User;
use \App\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* view posts of following users */
    public function index()
    {
        $user = Auth::user();
        $ids = $user->following->pluck('user_id');
        $posts = Post::whereIn('user_id', $ids)->orderBy('created_at', 'desc')->get();

        return view('post.index', compact('posts'));
    }

    /* view one post */
    public function show(Post $post)
    {
        $liked = $post->authUserLikedPost();

        $result = $post->countLikers();
        $likers = $result[0];
        $others = $result[1];

        return view('post.show', compact('post', 'liked', 'likers', 'others'));
    }

    public function likers(Request $request)
    {
        $postId = $request->segment(2);
        $post = Post::find($postId);

        $result = $post->countLikers();
        $likers = $result[0];
        $others = $result[1];

        $authUserLikedPost = $post->authUserLikedPost();

        return [
            "likers" => $likers,
            "others" => $others,
            "authUserLikedPost" => $authUserLikedPost
        ];
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
