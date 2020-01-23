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
        return $this->avatar ?
            "/storage/$this->avatar" :
            "https://robohash.org/$this->user_id.jpeg?size=200x200&bgset=bg1";
    }
}
