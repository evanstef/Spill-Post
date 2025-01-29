<?php

namespace App\Http\View\Composers;

use App\Models\Notification;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationComposer
{
    public function compose(View $view)
    {
        // Mendapatkan notifikasi yang belum dibaca dari user yang sedang login
        $unReadNotifications = Auth::check()
            ? Notification::query()->where('user_id', Auth::user()->id)->where('is_read', false)->get()
            : collect(); // Return koleksi kosong jika user tidak login

        // Kirim data ke semua view yang menggunakan composer ini
        $view->with('unReadNotifications', $unReadNotifications);
    }
}

