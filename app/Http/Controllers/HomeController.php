<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        // fitur sorting list postingan default nya latest
        $sortValue = $request->get('sort', 'newest');

        // untuk menampikan semua postingan
        $query = Post::query();

        // data user user di acak namun ambil 5 user saja di web ini
        $users = User::with('posts')->inRandomOrder()->limit(5)->get();

        // mengambil sortingan sesuai inputan user
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

        // menampilkan semua postingan yang sudah di sort sesuai dengan keinginan user
        $posts = $query->paginate(5)->appends(['sort' => $sortValue]);


        return view('home',
            [
                'users' => $users,
                'posts' => $posts
            ]);
    }

    // pencarian semua user
    public function searchUsers(Request $request) {
        $searchUser = $request->input('search');

        if (strlen($searchUser) < 1) {
            return response()->json([]);
        }

        $users = User::query()->where('username', 'like', '%' . $searchUser . '%')
                              ->orWhere('name', 'like', '%' . $searchUser . '%')
                              ->get();
        return response()->json($users);

    }

}
