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
        $logs = $query->paginate(20)->withQueryString();
        return view('admin.activity_logs.index', compact('logs'));
    }
}

