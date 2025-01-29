<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use App\Models\User;
use Illuminate\Http\Request;

class HashtagController extends Controller
{
    //
    public function searchHashtag(Request $request) {
        $hashtagInput = $request->input('content_hashtag');

        preg_match_all('/(#\w+)/', $hashtagInput, $matches);

        // pengecekan pencarian hashtag bila user menginput tanda # diikuti dengan tanda # nya
        if(!empty($matches[1])) {

            $hashtags = $matches[1];

            // menampilkan hasil pencarian
            $results = Hashtag::where(function ($query) use ($hashtags) {
                foreach ($hashtags as $hashtag) {
                    $query->orWhere('name', 'like', '%' . $hashtag . '%');
                }
            })->latest()->limit(5)->get();

            return response()->json($results);
        } else {

            return response()->json([
                'message' => 'Hashtag must start with #'
            ]);
        }

    }

    // menampilkan postingan sesuai dengan hashtag nya
    public function showPostHashtag(Hashtag $hashtag) {

        // mencari postingan postingan dengan hashtag yang sesuai
        $posts = $hashtag->posts()->with('user')->latest()->paginate(5);

        // data user user di acak namun ambil 5 user saja di web ini
        $users = User::with('posts')->inRandomOrder()->limit(5)->get();


        return view('home', [
            'hashtag' => $hashtag->name, // ini merupakan nama hashtag nya
            'posts' => $posts,
            'users' => $users
        ]);
    }
}
