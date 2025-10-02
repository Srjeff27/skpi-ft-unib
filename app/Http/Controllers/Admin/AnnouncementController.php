<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\ActivityLogger;
use App\Models\User;
use App\Notifications\AnnouncementNotification;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::latest('published_at')->paginate(20);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        return view('admin.announcements.form', ['announcement' => new Announcement()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'message' => ['required','string'],
            'published_at' => ['nullable','date'],
        ]);
        $data['published_at'] = $data['published_at'] ?? now();

        $announcement = Announcement::create($data);
        // Kirim notifikasi ke semua mahasiswa
        User::where('role','mahasiswa')->select('id')->chunkById(500, function($users) use ($announcement) {
            foreach ($users as $u) {
                $u->notify(new AnnouncementNotification($announcement));
            }
        });
        ActivityLogger::log($request->user(), 'admin.announcements.store');
        return redirect()->route('admin.announcements.index')->with('status','Pengumuman dibuat');
    }

    public function destroy(Request $request, Announcement $announcement): RedirectResponse
    {
        $announcement->delete();
        ActivityLogger::log($request->user(), 'admin.announcements.destroy', $announcement);
        return back()->with('status','Pengumuman dihapus');
    }
}
