<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    // fitur untuk follows orang
    public function follows (Request $request, User $user) {

        $follower = $request->user();

        if (!$follower->following()->where('following_id', $user->id)->exists()) {
            $follower->following()->attach($user->id);
        }

        // untuk membuat notif follow user
        Notification::create([
            'user_id' => $user->id,
            'action_by' => Auth::user()->id,
            'type' => 'follow',
            'post_id' => null
        ]);

        return redirect()->back();
    }

    // fitur untuk unfollows
    public function unfollows (Request $request, User $user) {
        $follower = $request->user();

        if ($follower->following()->where('following_id', $user->id)->exists()) {
            $follower->following()->detach($user->id);
        }

        return redirect()->back();
    }
}
