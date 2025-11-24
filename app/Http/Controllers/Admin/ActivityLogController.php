<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $query = ActivityLog::query()->with('user')->latest();

        if ($request->filled('action')) {
            $query->where('action', $request->string('action'));
        }
        if ($request->filled('role')) {
            $query->whereHas('user', fn($q) => $q->where('role', $request->string('role')));
        }
        if ($request->filled('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->string('search') . '%'));
        }

        $logs = $query->paginate(20)->withQueryString();
        $actions = ActivityLog::query()->select('action')->distinct()->pluck('action');

        return view('admin.activity_logs.index', compact('logs', 'actions'));
    }
}

