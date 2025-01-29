<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Services\ImageKitService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ProfileController extends Controller

{
    protected $imageKitService;

    public function __construct(ImageKitService $imageKitService)
    {
        $this->imageKitService = $imageKitService;
    }

    // Akhir Image Kit Service
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // menampilkan halaman profile user masing masing
    public function showUserProfile(Request $request, User $user) {
        // Mendapatkan ID user yang sedang login
        $loggedInUser = $request->user();

        $followers = collect();
        // Menampilkan followers user masing-masing
        // pengecekan bila user belum login tampilkan followers seperti biasa
        if (!$loggedInUser) {
          $followers = $user->followers()->with('posts')->get();
        } else {
           $followers = $user->followers()->with('posts')->get()->sortByDesc(function ($follower) use ($loggedInUser) {
            // Cek apakah user yang login sudah mengikuti follower ini
            return $loggedInUser->isFollowing($follower->id);
            });
        }

        // menampilkan following dari masing masing user
        $followings = $user->following()->with('posts')->latest()->get();

        // menampilkan semua postingan dari masing masing user
        $posts = $user->posts()->with('user')->orderBy('created_at', 'desc')->paginate(4);

        // menampilkan semua postingan yang di bookmarks oleh user
        $bookmarks = $user->bookmarksByUsers()->orderBy('created_at', 'desc')->paginate(4);

        // menampilkan profile user masing masing
        return view('profile.show', [
            'bookmarks' => $bookmarks,
            'posts' => $posts,
            'user' => $user,
            'followers' => $followers,
            'followings' => $followings
        ]);
    }

    // menampilkan halama bookmarks yang berada di profile user
    public function showUserBookmarks(User $user) {
        $loggedInUser = request()->user();

        // filter dari user yang sudah diiikut oleh user login
        $followers = $user->followers()->with('posts')->get()->sortByDesc(function ($follower) use ($loggedInUser) {
            // Cek apakah user yang login sudah mengikuti follower ini
            return $loggedInUser->isFollowing($follower->id);
        });



        // menampilkan following dari masing masing user
        $followings = $user->following()->with('posts')->latest()->get();

        // menampilkan semua postingan dari masing masing user
        $posts = $user->posts()->with('user')->orderBy('created_at', 'desc')->paginate(4);

        // menampilkan semua postingan yang di bookmarks oleh user
        $bookmarks = $user->bookmarksByUsers()->orderBy('created_at', 'desc')->paginate(4);

        // pengecekan bila user iseng mengunjungi halaman bookmark yang tidak login
        if ($user->id === Auth::user()->id) {
            return view('profile.show', [
                'bookmarks' => $bookmarks,
                'posts' => $posts,
                'user' => $user,
                'followers' => $followers,
                'followings' => $followings
            ]);
        } else {
            return redirect()->route('profile.show', $user->username);
        }

    }

    // ganti image profile
    public function updateUserImage(Request $request)
    {
        // Validasi file yang diunggah
        $request->validate([
            'image' => ['required', 'image' ,'mimes:png,jpg,jpeg'],
        ]);

        // Ambil file dari request
        $file = $request->file('image');

        // filename untuk profile users
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Simpan file di direktori ke ImageKit.io
        $imagePath = $this->imageKitService->upload(
            $file,
            $fileName,
            'users'
        );

        // Update kolom 'image' dari user yang terautentikasi
        User::where('id', Auth::id())->update([
            'image' => $imagePath,
        ]);

        // Bisa menambahkan response atau redirect setelah update
        return redirect()->back()->with('status', 'image-updated');

    }
}
