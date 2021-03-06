<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Profile;
use App\Post;
use App\Http\Controllers\FollowController;


class ProfileController extends Controller
{
    public function show(User $user)
    {
        $authUser = Auth::user();
        $following = false;
        if (isset($authUser)) {
            $following = $user->profile->followers->contains($authUser->id);
        }

        $data = FollowController::count($user);
        $firstFollowersNames = $data['firstFollowersNames'];
        $restFollowers = $data['restFollowers'];

        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('profile.show', compact('user', 'posts', 'following', 'firstFollowersNames', 'restFollowers'));
    }

    public function edit(User $user)
    {
        $profiles = Profile::findOrFail(["user_id" => $user->id]);
        $profile = $profiles[0];
        $this->authorize('edit', $profile);
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request, $user)
    {
        /* checking user authorization */
        $profiles = Profile::findOrFail(["user_id" => $user]);
        $profile = $profiles[0];
        $this->authorize('update', $profile);

        $validatedData = $request->validate([
            "description" => ["required", "string"],
            "website" => ["nullable", "url"],
            "image" => ["nullable", "image"]
        ]);

        $imgPath = null;
        if (isset($validatedData['image'])) {
            $imgPath = $validatedData['image']->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imgPath}"))->fit(400, 400);
            $image->save();
        }

        /* delete previous img */
        $oldImgPath = $request->user()->profile->avatar;
        if ($imgPath && $oldImgPath) {
            unlink(storage_path("app/public/$oldImgPath"));
        }

        $imgArray = $imgPath ? ['avatar' => $imgPath] : [];

        $dataToStore = [];
        if (isset($validatedData['description'])) {
            $dataToStore['description'] = $validatedData['description'];
        }
        if (isset($validatedData['website'])) {
            $dataToStore['website'] = $validatedData['website'];
        }
        if (isset($validatedData['image'])) {
            $dataToStore['avatar'] = $validatedData['image'];
        }

        $request->user()->profile->update(
            array_merge($dataToStore, $imgArray)
        );

        $userId = $request->user()->id;
        return redirect("/profiles/$userId");
    }
}
