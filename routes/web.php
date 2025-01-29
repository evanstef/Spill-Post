<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HashtagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostFollowingController;
use App\Http\Controllers\ProfileController;
use App\Models\Comment;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// menampilkan detail dari user masing masing
Route::get('/profile/{user:username}', [ProfileController::class, 'showUserProfile'])->name('profile.show');

// menampilkan detail dari postingan masing masing
Route::get('/post/{post}', [PostController::class, 'showPost'])->name('post.show');

// menampilkan postingan berdasarkan hashtag nya
Route::get('/post/hashtag/{hashtag:name}', [HashtagController::class, 'showPostHashtag'])->name('post.hashtag.show');

// pencarian user
// Route::get('/api/users/search', [HomeController::class, 'searchUsers'])->name('search.users');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // fitur bookmarks
    Route::post('/post/{post}/bookmark', [PostController::class, 'bookmark'])->name('post.bookmark');
    Route::delete('/post/{post}/unbookmark', [PostController::class, 'unbookmark'])->name('post.unbookmark');

    // fitur hapus postingan user
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');

    // update user image
    Route::post('/profile/update-user-image', [ProfileController::class, 'updateUserImage'])->name('profile.update-user-image');

    // menampilkan halaman bookmarks yang berada di profile user
    Route::get('/profile/{user:username}/bookmarks', [ProfileController::class, 'showUserBookmarks'])->name('profile.bookmarks');

    // membuat postingan
    Route::post('/create-post', [PostController::class, 'createPost'])->name('post.create');

    // fitur like dan unlike postingan
    Route::post('/post/{post}/like', [PostController::class, 'like'])->name('post.like');
    Route::delete('/post/{post}/unlike', [PostController::class, 'unlike'])->name('post.unlike');

    // fitur komen postingan
    Route::post('/post/{post}/comment', [PostController::class, 'createComment'])->name('post.comment');

    // fitur like dan unlike comment
    Route::post('/comment/{comment}/like', [CommentController::class, 'likeComment'])->name('post.comment.like');
    Route::delete('/comment/{comment}/unlike', [CommentController::class, 'unlikeComment'])->name('post.comment.unlike');

    // fitur reply komen postingan
    Route::post('/comment/{comment}/reply', [CommentController::class, 'replyComment'])->name('post.comment.reply');

    // fitur follow orang
    Route::post('/follows/{user}', [FollowController::class, 'follows'])->name('follows');
    Route::delete('/unfollows/{user}', [FollowController::class, 'unfollows'])->name('unfollows');

    // menampilkan semua post yang diikuti user
    Route::get('/following', [PostFollowingController::class, 'showPostFollowing'])->name('post.following');

    // menampilkan semua notif
    Route::get('/notification', [NotificationController::class, 'index'])->name('notification');

    // untuk menandai semua notif di read
    Route::post('/notification/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notification.mark-all-as-read');

    // menghapus semua notifikasi pada user yang saat ini sedang login
    Route::delete('/notification/delete-all', [NotificationController::class, 'deleteAllNotification'])->name('notification.delete-all');
});

require __DIR__.'/api.php';
require __DIR__.'/auth.php';

