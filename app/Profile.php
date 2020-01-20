<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use \App\User;

class Profile extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAvatar()
    {
        $userId = request()->segment(2);
        $user = User::find($userId);
        $avatar = $user->profile->avatar;
        if ($avatar) {
            return "/storage/$avatar";
        } else {
            return "https://robohash.org/$userId.jpeg?size=200x200&bgset=bg1";
        }
    }
}
