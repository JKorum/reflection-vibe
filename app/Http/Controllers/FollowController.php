<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggle(User $user)
    {
        $authUser = User::find(Auth::user()->id);
        $authUser->following()->toggle($user->profile);
    }

    public static function count(User $user)
    {
        /* grabing first followers' names -> max 3 */
        $firstFollowersNames = '';
        $count = $user->profile->followers()->count();
        $iteration = 0;

        if ($count > 0) {
            /* user has followers */
            for ($i = 0; $i < $count; $i++) {
                if ($iteration === 3) {
                    break;
                } elseif ($iteration === $count - 1 || $iteration + 1 === 3) {
                    /* last item */
                    $username = $user->profile->followers[$i]->username;
                    $firstFollowersNames .= "$username";
                    break;
                } else {
                    $username = $user->profile->followers[$i]->username;
                    $firstFollowersNames .= "$username,";
                    $iteration++;
                }
            }
        }

        /* counting rest followers */
        $restFollowers = 0;
        if ($count > 0) {
            $restFollowers = $count - ($iteration + 1);
        }

        return [
            "firstFollowersNames" => $firstFollowersNames,
            "restFollowers" => $restFollowers,
            "followersTotal" => $count
        ];
    }
}
