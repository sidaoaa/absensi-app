<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Model User
use App\Models\Presence; // Model Presence
use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;

class SummaryController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Ambil aktivitas hari ini
        $recentActivities = Presence::with('user')
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    
        $employees = User::all();
        $attendances = Presence::whereDate('in_time', $today)->get();
    
        $onTimeInCounts = $attendances->where('in_info', 'tepat')->count();
        $lateInCounts = $attendances->where('in_info', 'telat')->count();
        $onTimeOutCounts = $attendances->where('out_info', 'tepat')->count();
        $lateOutCounts = $attendances->where('out_info', 'bolos')->count();
    
        $summary = [
            'total_employees' => $employees->count(),
            'total_present' => $attendances->count(),
            'on_time_in' => $onTimeInCounts,
            'late_in' => $lateInCounts,
            'on_time_out' => $onTimeOutCounts,
            'late_out' => $lateOutCounts,
        ];
    
        return view('admin.summary', compact('recentActivities', 'summary'));
    }

    public function karyawan()
    {
        // Mengambil data karyawan
        $employees = User::all();
        // Mengambil data kehadiran
        $attendances = Presence::all();

        // Menghitung ringkasan data
        $summary = [
            'total_employees' => $employees->count(),
        ];
       
        // Return the view for the karyawan
        return view('admin.karyawan', compact('summary', 'employees'));
    }

    public function absenIn(Request $request)
    {
        $dateFilter = $request->get('filter', 'today');
        $attendances = [];

        switch ($dateFilter) {
            case 'weekly':
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
                $attendances = Presence::whereDate('in_time', '>=', $start)
                    ->whereDate('in_time', '<=', $end)
                    ->get();
                break;
            case 'monthly':
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
                $attendances = Presence::whereDate('in_time', '>=', $start)
                    ->whereDate('in_time', '<=', $end)
                    ->get();
                break;
            case 'today':
            default:
                $today = Carbon::today();
                $attendances = Presence::whereDate('in_time', $today)->get();
                break;
        }

        $summary = [
            'total_inpresent' => $attendances->count(),
        ];

        return view('admin.in', compact('summary', 'attendances'));
    }

    public function absenOut(Request $request)
    {
        $dateFilter = $request->get('filter', 'today');
        $attendances = [];
    
        switch ($dateFilter) {
            case 'weekly':
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
                $attendances = Presence::whereNotNull('out_time')
                    ->whereDate('out_time', '>=', $start)
                    ->whereDate('out_time', '<=', $end)
                    ->get();
                break;
            case 'monthly':
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
                $attendances = Presence::whereNotNull('out_time')
                    ->whereDate('out_time', '>=', $start)
                    ->whereDate('out_time', '<=', $end)
                    ->get();
                break;
            case 'today':
            default:
                $today = Carbon::today();
                $attendances = Presence::whereNotNull('out_time')
                    ->whereDate('out_time', $today)
                    ->get();
                break;
        }
    
        $summary = [
            'total_outpresent' => $attendances->count(),
        ];
    
        return view('admin.out', compact('summary', 'attendances'));
    }

    public function report(Request $request)
    {
        // Mendapatkan tanggal mulai dan tanggal akhir dari request atau menggunakan tanggal hari ini sebagai default
        $startDate = $request->input('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));

        // Mengambil data absensi berdasarkan rentang tanggal
        $attendances = Presence::whereDate('in_time', '>=', $startDate)
            ->whereDate('in_time', '<=', $endDate)
            ->with('user') // Memuat relasi user jika ada
            ->get();

        // Menghitung total absensi
        $totalInPresent = $attendances->count();

        // Menyiapkan data untuk dikirim ke view
        return view('admin.report', [
            'attendances' => $attendances,
            'summary' => [
                'total_inpresent' => $totalInPresent,
            ],
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }

}
