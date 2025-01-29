<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostFollowingController extends Controller
{
    // menampilkan postingan yang diikuti user
    public function showPostFollowing(Request $request) {
        $userLogin = $request->user();
        // mengambil input select dari user
        $sortValue = $request->get('sort_page_following', 'newest');


        // mengambil semua user yang ada di database secara random
        $allUsers = User::with('posts')->inRandomOrder()->latest()->paginate(6);

        // mengambil 5 user acak
        $usersLimit = User::with('posts')->inRandomOrder()->limit(5)->get();

        // untuk menampilkan semua postingan dari user yang diikuti
        $posts = collect();

        // mengambil semua user yang diikuti
        $usersFollowing = $userLogin->following()->get();

        // mengambil id user yang diikuti
        $userFollowingId= $userLogin->following()->pluck('following_id');

        // mengambil postingan dari user yang diikuti
        $query = Post::query()->whereIn('user_id', $userFollowingId);

       // Mengatur sorting berdasarkan inputan user
        switch ($sortValue) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'mostLiked':
                $query->withCount('likedByUsers')->orderBy('liked_by_users_count', 'desc');
                break;
            case 'mostComment':
                $query->withCount('comments')->orderBy('comments_count', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Mendapatkan postingan dengan pagination
        $posts = $query->paginate(5)->appends(['sort_page_following' => $sortValue]);



        return view('post.following', [
            'allUsers' => $allUsers,
            'usersLimit' => $usersLimit,
            'usersFollowing' => $usersFollowing,
            'posts' => $posts
        ]);
    }
}

