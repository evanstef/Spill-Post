<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Not;

class NotificationController extends Controller
{
    //untuk menampilkan semua notif user yang sedang login pada saat ini
    public function index () {
        $notifications = Notification::query()->where('user_id', Auth::user()->id)->latest()->paginate(10);
        return view('notification.show', [
            'notifications' => $notifications,
        ]);
    }

    // untuk menandai semua notif di read
    public function markAllAsRead () {
        // untuk menandai semua notif di read
        Notification::query()->where('user_id', Auth::user()->id)->update(['is_read' => true]);
        return redirect()->back();
    }

    // menghapus semua notifikasi pada user yang saat sedang login
    public function deleteAllNotification () {
        // menghapus semua notifikasi pada user yang saat sedang login
        Notification::query()->where('user_id', Auth::user()->id)->delete();
        return redirect()->back();
    }
}
