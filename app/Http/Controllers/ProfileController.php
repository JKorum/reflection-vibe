<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('profile.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            "description" => ["required", "string"],
            "website" => ["nullable", "url"],
            "avatar" => ["nullable", "image"]
        ]);

        $imgPath = null;
        if (isset($validatedData['avatar'])) {
            $imgPath = $validatedData['avatar']->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imgPath}"))->fit(400, 400);
            $image->save();
        }

        /* delete previous img */
        $oldImgPath = $request->user()->profile->avatar;
        if ($imgPath && $oldImgPath) {
            unlink(storage_path("app/public/$oldImgPath"));
        }

        $imgArray = $imgPath ? ['avatar' => $imgPath] : [];
        $request->user()->profile->update(
            array_merge($validatedData, $imgArray)
        );

        $userId = $request->user()->id;
        return redirect("/profiles/$userId");
    }
}
