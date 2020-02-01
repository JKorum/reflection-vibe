<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Support\Facades\Auth;
use \App\User;

class Post extends Model
{
    use HasComments;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /* to shorten post description and comments text */
    public function shortenCaption($caption, $limit)
    {
        $short = null;
        $more = false;

        if (strlen($caption) > $limit) {
            $short = substr($caption, 0, $limit);
            $more = true;
        } else {
            $short = $caption;
        }

        return ["short" => $short, "more" => $more];
    }

    /* to get first comments of post */
    public function getFirstComments($chunk)
    {
        $comments = null;
        if ($this->comments()->count() > 0) {
            $chunked = $this->comments->chunk($chunk);
            $comments = $chunked[0];
        }

        $comments = $comments->map(function ($item, $key) {
            $user = User::find($item['user_id']);
            $item['username'] = $user->username;
            return $item;
        });

        return $comments;
    }

    /* find out if user liked post */
    public function authUserLikedPost()
    {
        $liked = Like::where("user_id", Auth::user()->id)->where("post_id", $this->id)->get();
        $liked = isset($liked[0]) ? 1 : 0;

        return $liked;
    }

    /* count post likers */
    public function countLikers()
    {
        /* count likes */
        $likesCount = $this->likes()->count();

        /* find likers */
        $likers = '';
        $others = 0;
        if ($likesCount > 0) {
            for ($i = 0; $i < $likesCount; $i++) {
                $username = $this->likes[$i]->user->username;
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
}
