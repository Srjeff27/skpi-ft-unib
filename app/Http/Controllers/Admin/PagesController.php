<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Finalization;
use App\Models\Official;
use App\Models\User;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    public function finalisasi(Request $request): View
    {
        $periods = User::where('role','mahasiswa')
            ->whereNotNull('tanggal_lulus')
            ->selectRaw("DATE_FORMAT(tanggal_lulus, '%Y-%m') as ym")
            ->groupBy('ym')
            ->orderByDesc('ym')
            ->pluck('ym');

        $periode = $request->string('periode')->toString();
        $activeOfficials = Official::where('is_active',true)->orderBy('jabatan')->get();
        $record = $periode ? Finalization::firstOrNew(['period_ym'=>$periode]) : null;

        return view('admin.pages.finalisasi', compact('periods','periode','record','activeOfficials'));
    }

    public function setOfficial(Request $request)
    {
        $data = $request->validate([
            'periode' => ['required','date_format:Y-m'],
            'official_id' => ['required','exists:officials,id'],
        ]);
        $rec = Finalization::updateOrCreate(['period_ym'=>$data['periode']], [
            'official_id' => $data['official_id'],
        ]);
        return back()->with('status','Pejabat penandatangan ditetapkan untuk periode '.$data['periode']);
    }

    public function lock(Request $request)
    {
        $data = $request->validate([
            'periode' => ['required','date_format:Y-m'],
        ]);
        $rec = Finalization::firstOrCreate(['period_ym'=>$data['periode']]);
        if (!$rec->official_id) {
            return back()->withErrors(['periode'=>'Tetapkan pejabat terlebih dahulu.']);
        }

        $start = $data['periode'].'-01';
        $end = date('Y-m-d', strtotime($start.' +1 month'));
        $userIds = User::where('role','mahasiswa')->whereBetween('tanggal_lulus', [$start,$end])->pluck('id');
        DB::table('portfolios')
            ->whereIn('user_id', $userIds)
            ->where('status','verified')
            ->update(['is_locked'=>true,'finalized_at'=>now()]);

        $rec->is_locked = true;
        $rec->locked_at = now();
        $rec->save();

        return back()->with('status','Data periode '.$data['periode'].' telah dikunci.');
    }

    public function penerbitan(): View
    {
        return view('admin.pages.penerbitan');
    }

    public function pengaturan(Request $request): View
    {
        $logQuery = ActivityLog::query()->with('user')->latest();
        $filterUser = $request->integer('filter_user');
        $filterAction = $request->string('filter_action')->toString();
        $dateFrom = $request->date('date_from');
        $dateTo = $request->date('date_to');
        if ($filterUser) $logQuery->where('user_id',$filterUser);
        if ($filterAction) $logQuery->where('action',$filterAction);
        if ($dateFrom) $logQuery->whereDate('created_at','>=',$dateFrom);
        if ($dateTo) $logQuery->whereDate('created_at','<=',$dateTo);
        $logs = $logQuery->paginate(15)->withQueryString();
        $users = User::orderBy('name')->get(['id','name']);

        return view('admin.pages.pengaturan', compact('logs','users','filterUser','filterAction','dateFrom','dateTo'));
    }
}
