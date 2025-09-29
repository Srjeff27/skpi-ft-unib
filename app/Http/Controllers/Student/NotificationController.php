<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $notifications = $user->notifications()->latest()->paginate(20);
        return view('student.notifications.index', compact('notifications'));
    }

    public function markRead(Request $request, string $notification): RedirectResponse
    {
        $n = $request->user()->notifications()->where('id', $notification)->firstOrFail();
        if (! $n->read_at) $n->markAsRead();
        return back();
    }

    public function markUnread(Request $request, string $notification): RedirectResponse
    {
        $n = $request->user()->notifications()->where('id', $notification)->firstOrFail();
        if ($n->read_at) {
            $n->update(['read_at' => null]);
        }
        return back();
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();
        return back();
    }
}

